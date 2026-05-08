# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Projektübersicht

ThemePack ist ein proprietäres Contao-Bundle (`sgn47gradnord/themepack`, Namespace `Sgn47gradnord\Themepack`) der 47GradNord GmbH. Es liefert eigene Content Elements, Frontend-Module und Templates für Theme-basierte Websites und wird via Composer / Contao Manager als `contao-bundle` eingebunden.

## Technologie-Stack

- **PHP**: `^8.1` (8.3 empfohlen)
- **Contao**: `^5.3` (Core-Bundle, LTS)
- **Bundle-Typ**: `contao-bundle`, registriert über `ContaoManager\Plugin` (lädt nach `ContaoCoreBundle`)

Die Migration von Contao 4.x / PHP 7 auf Contao 5.3 / PHP 8.1+ ist mit den 3.x-Releases abgeschlossen (siehe `UPGRADE.md` für Migrationsdetails inkl. `TL_MODE`-Entfernung und `imagemargin`-Removal).

## Entwicklungskommandos

```bash
# Code-Style (Konfiguration in .php_cs)
vendor/bin/php-cs-fixer fix

# Dependencies
composer install
composer update
```

`.php_cs` erzwingt u.a. `@Symfony` + `@Symfony:risky`, `declare_strict_types`, `strict_comparison`, `strict_param`, kurze Array-Syntax und sortierte Imports — vor jedem Commit ausführen.

Es existiert aktuell **keine Test-Suite** im Repo (`.php_cs` referenziert `tests/`, der Ordner ist aber nicht angelegt).

## Architektur

### Big Picture

Das Bundle hängt sich an drei Contao-Erweiterungspunkte:

1. **Content Elements** (`$GLOBALS['TL_CTE']`) — Klassen unter `src/Element/`, registriert in `Resources/contao/config/config.php` in zwei Gruppen: `themepack-elements` und `themepack-swiperslider`.
2. **Frontend Modules** (`$GLOBALS['FE_MOD']['themepack']`) — Klassen unter `src/Module/`.
3. **Wrappers** (`$GLOBALS['TL_WRAPPERS']['start']` / `['stop']`) — `tp_swiperslider_*`, `tp_container_*`, `tp_section_*`. Start/Stop-Elemente **müssen** hier eingetragen sein, sonst behandelt Contao sie nicht als Wrapper.

DCA-Definitionen (Paletten, Subpaletten, Felder, SQL-Schema) liegen in `Resources/contao/dca/tl_content.php` und `tl_module.php`. Subpaletten werden über Selektoren wie `tpfeatureboxtype`, `tp_forward` getriggert. Validierung läuft über einen `onsubmit_callback` an `Backend\Callback::onsubmitCallbackTlContent`.

Konstante `$GLOBALS['THEMEPACK']['numberColumns']` definiert das eigene Spalten-Layout-System (`col_full`, `col_half`, `col_one_third` … `col_three_fifth`), genutzt von Featurebox/Textbox/Imagebox/TextImageBox.

### Klassenhierarchie

- Alle Content Elements erben von `Element\AbstractElement extends Contao\ContentElement` und implementieren `compile()` mit gesetztem `$strTemplate`.
- Alle Module erben von `Module\AbstractModule extends Contao\Module`. Helper: `getRootPageTitle()`, `getPageTitle()`, `generateWildcard()` (Backend-Platzhalter).
- Bildverarbeitung und URL-Erzeugung **immer** über `ContaoHelper` (statisch):
  - `addThemePackImageToTemplate()` — responsive Picture-Generierung über Contao Picture Factory inkl. Lightbox/Meta-Daten aus `FilesModel`. Direkte Nutzung der Contao Image API umgehen.
  - `createUrl()` / `getRootPageUrl()` — URL-Bau mit `League\Uri`, unterstützt `PageModel`-jumpTo und Query-String-Merge.

### Templates

Liegen unter `Resources/contao/templates/`:

- **`overwrite/`** — überschreibt Contao-Core-Templates (`nav_default.html5`, `mod_navigation.html5`, `mod_breadcrumb.html5`, `mod_article.html5`).
- **`element/`** — ein Template pro Content Element, Konvention `ce_tp_*.html5` (z.B. `ce_tp_featurebox.html5`, Variante `ce_tp_featurebox_icon_small.html5`). SwiperSlider-Templates unter `element/swiperslider/`.
- **`module/`** — Konvention `mod_tp_*.html5`. Headerbar hat Varianten: `boxed`, `transparent`, `transparent_full`, `floating`.
- **Direkt unter `templates/`**: `fe_page.html5` (Layout-Template mit Sections) und `js_themepack_setup.html5`.

Templates verwenden ThemePack-Felder (`$this->tp_*`), `$this->picture` (responsive Image), `$this->sections` in `fe_page`, `$item` in Navigations-Templates.

## PHP-8 / Contao-5-Pflichten beim Editieren von Templates

PHP 8 wirft `Warning: Undefined array key`, Contao 5 hat einige Variablen umbenannt. Beim Anfassen oder neu Anlegen eines Templates konsequent absichern:

```php
<?= $item['subitems'] ?? '' ?>
<?php if (!empty($item['accesskey'])): ?>…<?php endif; ?>
<?php if (array_key_exists('key', $array)): ?>…<?php endif; ?>
```

`TL_MODE` existiert in Contao 5 nicht mehr — stattdessen `$this->isFrontend` / `$this->isBackend`. Das `imagemargin`-Feld ist entfernt; Bildabstände müssen via CSS-Klassen am Element gelöst werden (Details in `UPGRADE.md`).

## Konventionen

- `declare(strict_types=1);` in jeder PHP-Datei.
- Strict Comparison (`===`/`!==`) — wird vom `.php_cs`-Regelwerk erzwungen.
- Neue Wrapper-Elemente: in `config.php` zusätzlich zu `TL_CTE` auch in `TL_WRAPPERS['start'|'stop']` eintragen.
- Sprachdateien nur in `Resources/contao/languages/de/` (keine weiteren Sprachen im Bundle).

## Git-Workflow

- Default-Branch: `develop`. Releases über `release/*`-Branches und Tags (Git-Flow-Stil, siehe `git log`).
- Main-Branch für PRs gegen Upstream: `main`.

## Referenzen

- `UPGRADE.md` — Schritt-für-Schritt-Migration Contao 4.x → 5.3 inkl. Breaking Changes, Troubleshooting, Rollback.
- `THEMEPACK.md` — Historische Notiz zur PHP-8.3-Template-Härtung (heute größtenteils im Bundle umgesetzt).

## Lizenz

Proprietary © 47GradNord — info@47gradnord.de.
