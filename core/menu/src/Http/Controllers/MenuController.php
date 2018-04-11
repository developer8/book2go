<?php

namespace Botble\Menu\Http\Controllers;

use Assets;
use Botble\Base\Events\BeforeEditContentEvent;
use Botble\Base\Events\CreatedContentEvent;
use Botble\Base\Events\DeletedContentEvent;
use Botble\Base\Events\UpdatedContentEvent;
use Botble\Base\Forms\FormBuilder;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Http\Responses\AjaxResponse;
use Botble\Menu\Forms\MenuForm;
use Botble\Menu\Tables\MenuTable;
use Botble\Menu\Http\Requests\MenuRequest;
use Botble\Menu\Repositories\Eloquent\MenuRepository;
use Botble\Menu\Repositories\Interfaces\MenuInterface;
use Botble\Menu\Repositories\Interfaces\MenuNodeInterface;
use Botble\Support\Services\Cache\Cache;
use Exception;
use Illuminate\Http\Request;
use Menu;
use stdClass;

class MenuController extends BaseController
{

    /**
     * @var MenuInterface
     */
    protected $menuRepository;

    /**
     * @var MenuNodeInterface
     */
    protected $menuNodeRepository;

    /**
     * @var Cache
     */
    protected $cache;

    /**
     * MenuController constructor.
     * @param MenuInterface $menuRepository
     * @param MenuNodeInterface $menuNodeRepository
     * @author Sang Nguyen
     */
    public function __construct(
        MenuInterface $menuRepository,
        MenuNodeInterface $menuNodeRepository
    ) {
        $this->menuRepository = $menuRepository;
        $this->menuNodeRepository = $menuNodeRepository;
        $this->cache = new Cache(app('cache'), MenuRepository::class);
    }

    /**
     * @param MenuTable $dataTable
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author Sang Nguyen
     */
    public function getList(MenuTable $dataTable)
    {
        page_title()->setTitle(trans('core.menu::menu.name'));

        return $dataTable->renderTable(['title' => trans('core.menu::menu.name')]);
    }

    /**
     * @return string
     * @author Sang Nguyen
     */
    public function getCreate(FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('core.menu::menu.create'));

        return $formBuilder->create(MenuForm::class)->renderForm();
    }

    /**
     * @param MenuRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @author Sang Nguyen, Tedozi Manson
     */
    public function postCreate(MenuRequest $request)
    {
        $menu = $this->menuRepository->getModel();

        $menu->name = $request->input('name');
        $menu->slug = $this->menuRepository->createSlug($request->input('name'));
        $menu = $this->menuRepository->createOrUpdate($menu);

        $this->cache->flush();

        event(new CreatedContentEvent(MENU_MODULE_SCREEN_NAME, $request, $menu));

        if ($request->input('submit') === 'save') {
            return redirect()->route('menus.list')->with('success_msg', trans('core.base::notices.create_success_message'));
        } else {
            return redirect()->route('menus.edit', $menu->id)->with('success_msg', trans('core.base::notices.create_success_message'));
        }
    }

    /**
     * @param $id
     * @param Request $request
     * @param FormBuilder $formBuilder
     * @return string
     * @author Sang Nguyen, Tedozi Manson
     */
    public function getEdit($id, Request $request, FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('core.menu::menu.edit'));

        Assets::addJavascript(['jquery-nestable']);
        Assets::addStylesheets(['jquery-nestable']);
        Assets::addAppModule(['menu']);

        $oldInputs = old();
        if ($oldInputs && $id == 0) {
            $oldObject = new stdClass();
            foreach ($oldInputs as $key => $row) {
                $oldObject->$key = $row;
            }
            $menu = $oldObject;
        } else {
            $menu = $this->menuRepository->findById($id);
            if (!$menu) {
                $menu = $this->menuRepository->getModel();
            }
        }

        event(new BeforeEditContentEvent(MENU_MODULE_SCREEN_NAME, $request, $menu));

        return $formBuilder->create(MenuForm::class)->setModel($menu)->renderForm();
    }

    /**
     * @param MenuRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @author Sang Nguyen, Tedozi Manson
     */
    public function postEdit(MenuRequest $request, $id)
    {
        $menu = $this->menuRepository->getModel()->findOrNew($id);

        $menu->name = $request->input('name');
        $this->menuRepository->createOrUpdate($menu);
        event(new UpdatedContentEvent(MENU_MODULE_SCREEN_NAME, $request, $menu));

        $deletedNodes = explode(' ', ltrim($request->get('deleted_nodes', '')));
        $this->menuNodeRepository->getModel()->whereIn('id', $deletedNodes)->delete();
        Menu::recursiveSaveMenu(json_decode($request->get('menu_nodes'), true), $menu->id, 0);

        $this->cache->flush();

        if ($request->input('submit') === 'save') {
            return redirect()->route('menus.list')->with('success_msg', trans('core.base::notices.create_success_message'));
        } else {
            return redirect()->route('menus.edit', $id)->with('success_msg', trans('core.base::notices.create_success_message'));
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @param AjaxResponse $response
     * @return AjaxResponse
     * @author Sang Nguyen
     */
    public function getDelete(Request $request, $id, AjaxResponse $response)
    {
        try {
            $menu = $this->menuRepository->findById($id);
            $this->menuNodeRepository->deleteBy(['menu_id' => $menu->id]);
            $this->menuRepository->delete($menu);

            event(new DeletedContentEvent(MENU_MODULE_SCREEN_NAME, $request, $menu));

            return $response->setMessage(trans('core.base::notices.delete_success_message'));
        } catch (Exception $ex) {
            return $response->setError(true)->setMessage($ex->getMessage());
        }
    }

    /**
     * @param Request $request
     * @param AjaxResponse $response
     * @return AjaxResponse
     * @author Sang Nguyen
     */
    public function postDeleteMany(Request $request, AjaxResponse $response)
    {
        $ids = $request->input('ids');
        if (empty($ids)) {
            return $response->setError(true)->setMessage(trans('core.base::notices.no_select'));
        }

        foreach ($ids as $id) {
            $menu = $this->menuRepository->findById($id);
            $this->menuNodeRepository->deleteBy(['menu_id' => $menu->id]);
            $this->menuRepository->delete($menu);
            event(new DeletedContentEvent(MENU_MODULE_SCREEN_NAME, $request, $menu));
        }

        return $response->setMessage(trans('core.base::notices.delete_success_message'));
    }

    /**
     * @param Request $request
     * @return AjaxResponse
     * @author Sang Nguyen
     */
    public function postChangeStatus(Request $request, AjaxResponse $response)
    {
        $ids = $request->input('ids');
        if (empty($ids)) {
            return $response->setError(true)->setMessage(trans('core.base::notices.no_select'));
        }

        foreach ($ids as $id) {
            $menu = $this->menuRepository->findById($id);
            $menu->status = $request->input('status');
            $this->menuRepository->createOrUpdate($menu);
            event(new UpdatedContentEvent(MENU_MODULE_SCREEN_NAME, $request, $menu));
        }

        return $response->setData($request->input('status'))->setMessage(trans('core.base::notices.update_success_message'));
    }
}
