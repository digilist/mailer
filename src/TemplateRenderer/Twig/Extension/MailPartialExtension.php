<?php

namespace Daa\Library\Mail\TemplateRenderer\Twig\Extension;

use Daa\Library\Mail\Message\MessageInterface;
use Daa\Library\Mail\TemplateRenderer\TemplateRenderingException;
use Daa\Library\Mail\TemplateResolver\TemplateResolverInterface;
use Daa\Library\Mail\TemplateResolver\UnresolvableException;
use Error;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * This twig extensions adds the ability to include partials into mails
 */
class MailPartialExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction(
                'partial',
                [$this, 'twigPartial'],
                ['needs_environment' => true, 'needs_context' => true, 'is_safe' => ['html']]
            ),
            new TwigFunction(
                'partial_if_exists',
                [$this, 'twigPartialIfExists'],
                ['needs_environment' => true, 'needs_context' => true, 'is_safe' => ['html']]
            ),
            new TwigFunction(
                'partial_string',
                [$this, 'twigPartialString'],
                ['needs_environment' => true, 'needs_context' => true, 'is_safe' => ['html']]
            ),
        ];
    }

    /**
     * Include another template.
     *
     * @param Environment $environment
     * @param array            $context
     * @param string           $partialKey
     * @param array            $overrides
     *
     * @return string
     * @throws \Exception
     */
    public function twigPartial(Environment $environment, array $context, $partialKey, array $overrides = [])
    {
        /** @var TemplateResolverInterface $templateResolver */
        $templateResolver = $context['template_resolver'];

        /** @var MessageInterface $message */
        $message = $context['message'];
        $locale = $context['locale'];

        $context = array_merge($context, $overrides);

        $template = $templateResolver->resolveTemplate($partialKey, $locale, $message);

        try {
            return $environment->createTemplate($template)->render($context);
        } catch (Error $e) {
            throw TemplateRenderingException::renderingFailed($partialKey, $e);
        }
    }

    /**
     * Include another template, but only if it exists. Otherwise it will be skipped.
     *
     * @param Environment $environment
     * @param array             $context
     * @param string            $partialKey
     *
     * @return string
     * @throws \Exception
     */
    public function twigPartialIfExists(Environment $environment, array $context, $partialKey)
    {
        try {
            return $this->twigPartial($environment, $context, $partialKey);
        } catch (UnresolvableException $e) {
            return '';
        }
    }

    /**
     * Include another template which is passed as parameter.
     *
     * @param Environment $environment
     * @param array             $context
     * @param string            $partial
     *
     * @return string
     */
    public function twigPartialString(Environment $environment, array $context, $partial)
    {
        try {
            return $environment->createTemplate($partial)->render($context);
        } catch (Error $e) {
            throw TemplateRenderingException::renderingFailed($partial, $e);
        }
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'mail_partial';
    }
}
