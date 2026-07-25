<?php
namespace Grav\Plugin;

use Grav\Common\Plugin;
use RocketTheme\Toolbox\Event\Event;

class AuraSuitePlugin extends Plugin
{
    public function onPluginsInitialized(): void
    {
        if ($this->isAdmin()) {
            $this->enable([
                'onGetPageBlueprints' => ['onGetPageBlueprints', 0],
                'onAdminSave'         => ['onAdminSave', 0],
            ]);
            return;
        }

        $this->enable([
            'onTwigSiteVariables'    => ['onTwigSiteVariables', 0],
            'onTwigTemplatePaths'    => ['onTwigTemplatePaths', 0],
            'onPageContentProcessed' => ['onPageContentProcessed', 0],
        ]);
    }

    public function onGetPageBlueprints(Event $event): void
    {
        $event->types->scanBlueprints('plugins://' . $this->name . '/blueprints');
    }

    /**
     * Intercetta il salvataggio della configurazione del plugin e genera 'authors_list'
     */
    /**
     * Intercetta il salvataggio della configurazione del plugin e genera automaticamente 'authors_list'
     */
    public function onAdminSave(Event $event): void
    {
        $object = $event['object'];

        // Sostituito ->has('authors') con isset($object['authors']) per compatibilità con Grav Data
        if ($object instanceof \Grav\Common\Data\Data && isset($object['authors'])) {
            $authors = $object->get('authors', []);
            $flatList = [];

            if (is_iterable($authors)) {
                foreach ($authors as $author) {
                    $authorArr = (array) $author;
                    if (!empty($authorArr['label'])) {
                        $key = (string) $authorArr['label'];
                        $val = (string) ($authorArr['name'] ?? $authorArr['label']);
                        $flatList[$key] = $val;
                    }
                }
            }

            // Ordina alfabeticamente la lista
            asort($flatList);

            // Scrive 'authors_list' nell'oggetto di configurazione prima che venga salvato su disco
            $object->set('authors_list', $flatList);
        }
    }

    public function onTwigSiteVariables(): void
    {
        $twig = $this->grav['twig'];
        $authors = $this->config->get('plugins.aura-suite.authors', []);

        $authorsMapped = [];
        foreach ($authors as $auth) {
            $authArr = (array) $auth;
            if (isset($authArr['label'])) {
                $authorsMapped[$authArr['label']] = $authArr;
            }
        }
        $twig->twig_vars['authors'] = $authorsMapped;

        $page = $this->grav['page'];
        if ($page) {
            $header = (array) $page->header();
            $aura = (array) ($header['aura'] ?? []);
            $authorKey = $aura['author'] ?? null;

            if (is_array($authorKey)) {
                $authorKey = reset($authorKey) ?: null;
            }

            $authorData = $authorsMapped[$authorKey] ?? null;

            if (!empty($aura)) {
                $jsonLd = [
                    '@context'    => 'https://schema.org',
                    '@type'       => ($aura['pagetype'] ?? 'article') === 'website' ? 'WebSite' : 'Article',
                    'headline'    => $page->title(),
                    'description' => $aura['description'] ?? $page->summary(),
                ];

                if ($authorData) {
                    $jsonLd['author'] = [
                        '@type' => 'Person',
                        'name'  => $authorData['name'] ?? $authorKey,
                        'url'   => $authorData['person-website-url'] ?? null
                    ];
                }

                $twig->twig_vars['aura_json_ld'] = json_encode($jsonLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            }
        }
    }

    public function onTwigTemplatePaths(): void
    {
        $this->grav['twig']->twig_paths[] = __DIR__ . '/templates';
    }

    public function onPageContentProcessed(Event $event): void
    {
        /** @var \Grav\Common\Page\Page $page */
        $page = $event['page'];

        if ($this->isAdmin() || $page->isModule()) {
            return;
        }

        if ($this->config->get('plugins.aura-suite.auto_append_author', true)) {
            $header = (array) $page->header();
            $aura = (array) ($header['aura'] ?? []);
            $authorKey = $aura['author'] ?? null;

            if (is_array($authorKey)) {
                $authorKey = reset($authorKey) ?: null;
            }

            if ($authorKey && is_string($authorKey)) {
                $authors = $this->config->get('plugins.aura-suite.authors', []);
                $authorData = null;

                foreach ($authors as $a) {
                    $aArr = (array) $a;
                    if (($aArr['label'] ?? '') === $authorKey) {
                        $authorData = $aArr;
                        break;
                    }
                }

                if ($authorData) {
                    $authorHtml = $this->grav['twig']->processTemplate('partials/author-bio.html.twig', [
                        'author' => $authorData
                    ]);

                    $rawContent = $page->getRawContent();
                    if (!str_contains($rawContent, 'aura-author-bio')) {
                        $page->setRawContent($rawContent . "\n\n" . $authorHtml);
                    }
                }
            }
        }
    }
}
