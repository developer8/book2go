<?php

namespace Botble\SeoHelper\Helpers;

use Botble\SeoHelper\Contracts\Helpers\MetaContract;
use Botble\SeoHelper\Exceptions\InvalidArgumentException;

class Meta implements MetaContract
{

    /**
     * Meta prefix name.
     *
     * @var string
     */
    protected $prefix = '';

    /**
     * The meta name property.
     *
     * @var string
     */
    protected $nameProperty = 'name';

    /**
     * Meta name.
     *
     * @var string
     */
    protected $name = '';

    /**
     * Meta content.
     *
     * @var string
     */
    protected $content = '';

    /**
     * Make Meta instance.
     *
     * @param  string $name
     * @param  string $content
     * @param  string $prefix
     * @param  string $propertyName
     * @author ARCANEDEV <arcanedev.maroc@gmail.com>
     */
    public function __construct($name, $content, $propertyName = 'name', $prefix = '')
    {
        $this->setPrefix($prefix);
        $this->setName($name);
        $this->setContent($content);
        $this->setNameProperty($propertyName);
    }

    /**
     * Get the meta name.
     *
     * @return string
     * @author ARCANEDEV <arcanedev.maroc@gmail.com>
     */
    public function key()
    {
        return $this->name;
    }

    /**
     * Set the meta prefix name.
     *
     * @param  string $prefix
     *
     * @return \Botble\SeoHelper\Helpers\Meta
     * @author ARCANEDEV <arcanedev.maroc@gmail.com>
     */
    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;

        return $this;
    }

    /**
     * Set the meta property name.
     *
     * @param  string $nameProperty
     *
     * @return \Botble\SeoHelper\Helpers\Meta
     * @author ARCANEDEV <arcanedev.maroc@gmail.com>
     */
    public function setNameProperty($nameProperty)
    {
        $this->checkNameProperty($nameProperty);
        $this->nameProperty = $nameProperty;

        return $this;
    }

    /**
     * Get the meta name.
     *
     * @param  bool $prefixed
     *
     * @return string
     * @author ARCANEDEV <arcanedev.maroc@gmail.com>
     */
    private function getName($prefixed = true)
    {
        $name = $this->name;

        if ($prefixed) {
            $name = $this->prefix . $name;
        }

        return $this->clean($name);
    }

    /**
     * Set the meta name.
     *
     * @param  string $name
     *
     * @return \Botble\SeoHelper\Helpers\Meta
     * @author ARCANEDEV <arcanedev.maroc@gmail.com>
     */
    private function setName($name)
    {
        $name = trim(strip_tags($name));
        $this->name = str_replace([' '], '-', $name);

        return $this;
    }

    /**
     * Get the meta content.
     *
     * @return string
     * @author ARCANEDEV <arcanedev.maroc@gmail.com>
     */
    private function getContent()
    {
        return $this->clean($this->content);
    }

    /**
     * Set the meta content.
     *
     * @param  string $content
     *
     * @return \Botble\SeoHelper\Helpers\Meta
     * @author ARCANEDEV <arcanedev.maroc@gmail.com>
     */
    private function setContent($content)
    {
        if (is_string($content)) {
            $this->content = trim($content);
        }

        return $this;
    }

    /**
     * Make Meta instance.
     *
     * @param  string $name
     * @param  string $content
     * @param  string $propertyName
     * @param  string $prefix
     *
     * @return \Botble\SeoHelper\Helpers\Meta
     * @author ARCANEDEV <arcanedev.maroc@gmail.com>
     */
    public static function make($name, $content, $propertyName = 'name', $prefix = '')
    {
        return new self($name, $content, $propertyName, $prefix);
    }

    /**
     * Render the tag.
     *
     * @return string
     * @author ARCANEDEV <arcanedev.maroc@gmail.com>
     */
    public function render()
    {
        if ($this->isLink()) {
            return $this->renderLink();
        }

        return $this->renderMeta();
    }

    /**
     * Render the link tag.
     *
     * @return string
     * @author ARCANEDEV <arcanedev.maroc@gmail.com>
     */
    private function renderLink()
    {
        return '<link rel="' . $this->getName(false) . '" href="' . $this->getContent() . '">';
    }

    /**
     * Render the meta tag.
     *
     * @return string
     * @author ARCANEDEV <arcanedev.maroc@gmail.com>
     */
    private function renderMeta()
    {
        $output = [];
        $output[] = $this->nameProperty . '="' . $this->getName() . '"';
        $output[] = 'content="' . $this->getContent() . '"';

        return '<meta ' . implode(' ', $output) . '>';
    }

    /**
     * Render the tag.
     *
     * @return string
     * @author ARCANEDEV <arcanedev.maroc@gmail.com>
     */
    public function __toString()
    {
        return $this->render();
    }

    /**
     * Check if meta is a link tag.
     *
     * @return bool
     * @author ARCANEDEV <arcanedev.maroc@gmail.com>
     */
    protected function isLink()
    {
        return in_array($this->name, [
            'alternate', 'archives', 'author', 'canonical', 'first', 'help', 'icon', 'index', 'last',
            'license', 'next', 'nofollow', 'noreferrer', 'pingback', 'prefetch', 'prev', 'publisher'
        ]);
    }

    /**
     * Check if meta is valid.
     *
     * @return bool
     * @author ARCANEDEV <arcanedev.maroc@gmail.com>
     */
    public function isValid()
    {
        return !empty($this->content);
    }

    /**
     * Check the name property.
     *
     * @param  string $nameProperty
     *
     * @throws InvalidArgumentException
     * @author ARCANEDEV <arcanedev.maroc@gmail.com>
     */
    private function checkNameProperty(&$nameProperty)
    {
        if (!is_string($nameProperty)) {
            throw new InvalidArgumentException(
                'The meta name property is must be a string value, ' . gettype($nameProperty) . ' is given.'
            );
        }

        $name = str_slug($nameProperty);
        $allowed = ['charset', 'http-equiv', 'itemprop', 'name', 'property'];

        if (!in_array($name, $allowed)) {
            throw new InvalidArgumentException(
                'The meta name property [' . $name . '] is not supported, ' .
                'the allowed name properties are ["' . implode("', '", $allowed) . '"].'
            );
        }

        $nameProperty = $name;
    }

    /**
     * Clean all the inputs.
     *
     * @param  string $value
     *
     * @return string
     * @author ARCANEDEV <arcanedev.maroc@gmail.com>
     */
    public function clean($value)
    {
        return htmlentities(strip_tags($value));
    }
}