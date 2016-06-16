<?php
/**
 * This file is part of the "Easy System" package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Damon Smith <damon.easy.system@gmail.com>
 */
namespace Es\ControllerPlugins\Plugin;

use Es\View\ViewTrait;

/**
 * Allows to change the layout parameters.
 *
 * The Layout would imply the "root" View Model.
 */
class Layout
{
    use ViewTrait;

    /**
     * Sets the layout template.
     *
     * @param string $template The template name
     *
     * @return self
     */
    public function setTemplate($template)
    {
        $layout = $this->getViewModel();
        $layout->setTemplate((string) $template);

        return $this;
    }

    /**
     * Gets the layout template.
     *
     * @return null|string The template name, if any
     */
    public function getTemplate()
    {
        $layout = $this->getViewModel();

        return $layout->getTemplate();
    }

    /**
     * Sets the layout module name.
     *
     * @param null|string $module The module name, if any
     *
     * @return self
     */
    public function setModule($module)
    {
        $layout = $this->getViewModel();
        $layout->setModule((string) $module);

        return $this;
    }

    /**
     * Gets the layout module name.
     *
     * @return string Module The module name
     */
    public function getModule()
    {
        $layout = $this->getViewModel();

        return $layout->getModule();
    }

    /**
     * Invoke as a functor.
     *
     * If no arguments are given, gets "root" ViewModel.
     * Otherwise sets template or module for layout and returns self.
     *
     * @param string $template Optional; the template name
     * @param string $module   Optional; the module name
     *
     * @return \Es\Mvc\ViewModelInterface|self The "root" ViewModel or self
     */
    public function __invoke($template = null, $module = null)
    {
        if (null === $template && null === $module) {
            return $this->getViewModel();
        }
        if (null !== $template) {
            $this->setTemplate($template);
        }
        if (null !== $module) {
            $this->setModule($module);
        }

        return $this;
    }

    /**
     * Gets the root view model.
     *
     * @return \Es\Mvc\ViewModelInterface The "root" ViewModel
     */
    protected function getViewModel()
    {
        $view  = $this->getView();
        $model = $view->getLayout();

        return $model;
    }
}
