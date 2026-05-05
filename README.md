# Shopware Design System Plugin

A generic, open-source Shopware 6 plugin that exposes a `/design-system` storefront page showcasing all Bootstrap components available in the default Shopware Storefront theme. Use it as a living style guide when building or customising a Shopware theme.

## Features

- `/design-system` storefront route (can be toggled per Sales Channel in the Admin)
- Sections for **Colors**, **Typography**, **Icons**, **Buttons**, **Inputs**, **Checkboxes / Radios / Toggles**, and **Alerts**
- Uses only standard Bootstrap 5 classes and the built-in Shopware `sw_icon` helper — no external dependencies
- Designed to be extended: add your own brand variables in `src/Resources/app/storefront/src/scss/abstract/_variables.scss`

## Requirements

| Dependency | Version |
|---|---|
| PHP | ≥ 8.1 |
| Shopware | ~6.6.0 |
| Composer | ≥ 2.0 |

> The plugin relies on the **default Shopware Storefront** theme which already bundles Bootstrap 5. No additional npm packages are required.

## Installation

### Via Composer (recommended)

1. Require the package in your Shopware project root:

```bash
composer require shopware-community/design-system-plugin
```

2. Install and activate the plugin:

```bash
bin/console plugin:refresh
bin/console plugin:install --activate ShopwareDesignSystem
bin/console cache:clear
```

3. Recompile the Storefront theme to include the plugin SCSS:

```bash
bin/console theme:compile
```

### Manual installation

1. Clone or download this repository into `custom/plugins/ShopwareDesignSystem`:

```bash
git clone https://github.com/shopware-community/shopware-design-system.git \
    custom/plugins/ShopwareDesignSystem
```

2. Install dependencies and activate:

```bash
composer dump-autoload
bin/console plugin:refresh
bin/console plugin:install --activate ShopwareDesignSystem
bin/console cache:clear
bin/console theme:compile
```

### Zip upload via Admin

1. Download the latest `.zip` from the [Releases](https://github.com/shopware-community/shopware-design-system/releases) page.
2. Go to **Extensions → My extensions → Upload extension** in the Shopware Admin.
3. Upload the zip, then click **Install** → **Activate**.
4. Run `bin/console theme:compile` from your server (or trigger a theme recompile via the Admin).

## Usage

After activation, open your browser and visit:

```
https://your-shop-domain.com/design-system
```

You will see the full component reference page.

### Disabling the page

The page can be disabled per Sales Channel via **Admin → Extensions → ShopwareDesignSystem → Configuration**:

| Setting | Type | Default | Description |
|---|---|---|---|
| `isDesignSystemAccessible` | boolean | `true` | When disabled, `/design-system` redirects to `/` |

> **Tip:** Disable the page in production and enable it only in staging/development environments.

## Customisation

### Adding brand variables

Override Bootstrap / Shopware SCSS variables in:

```
src/Resources/app/storefront/src/scss/abstract/_variables.scss
```

Example:

```scss
$primary:   #e63946;
$secondary: #457b9d;
$font-family-base: 'Inter', sans-serif;
```

After changing variables, recompile the theme:

```bash
bin/console theme:compile
```

### Adding your own design system sections

1. Create a new partial template, e.g. `src/Resources/views/storefront/page/design-system/badges.html.twig`.
2. Include it in `index.html.twig`:

```twig
<div class="design-system-section">
    {% sw_include "@ShopwareDesignSystem/storefront/page/design-system/badges.html.twig" %}
</div>
```

### Extending from a child plugin or theme

Override any partial by placing a template at the same relative path inside your theme:

```
YourTheme/src/Resources/views/storefront/page/design-system/buttons.html.twig
```

Use `{% sw_extends %}` inside that file to extend the original block.

## Project structure

```
ShopwareDesignSystem/
├── .gitignore
├── .github/workflows/ci.yml              # GitHub Actions: composer validate + PHP lint
├── composer.json
├── LICENSE
├── README.md
└── src/
    ├── ShopwareDesignSystem.php               # Plugin entry class
    ├── Storefront/
    │   └── Controller/
    │       └── DesignSystemController.php     # Route handler
    └── Resources/
        ├── app/storefront/src/
        │   ├── main.js                        # JS entry (empty by default)
        │   └── scss/
        │       ├── base.scss                  # SCSS entry
        │       ├── abstract/
        │       │   ├── _index.scss
        │       │   └── _variables.scss        # ← put your overrides here
        │       └── layout/
        │           ├── _index.scss
        │           └── _design-system.scss    # Page-specific layout styles
        ├── config/
        │   ├── config.xml                     # Admin plugin settings
        │   ├── routes.xml                     # Symfony route import
        │   └── services.xml                   # Service container definitions
        └── views/storefront/page/design-system/
            ├── index.html.twig                # Main page template
            ├── colors.html.twig               # Bootstrap color swatches
            ├── typography.html.twig           # Heading, body, list examples
            ├── icons.html.twig                # Shopware built-in icon library
            ├── buttons.html.twig              # Button variants, sizes, states
            ├── inputs.html.twig               # Form controls & validation
            ├── checkboxes.html.twig           # Checkboxes, radios, switches
            ├── messages.html.twig             # Bootstrap alert / flash messages
            ├── badges.html.twig               # Badge variants, pill, counter, status
            ├── cards.html.twig                # Card variants, product tiles, panels
            ├── tables.html.twig               # Table modifiers, responsive, contextual rows
            └── pagination.html.twig           # Pagination sizes, ellipsis, alignment
```

## Bootstrap components covered

| Section | Bootstrap classes demonstrated |
|---|---|
| **Colors** | `bg-*`, `bg-*-subtle`, `text-*`, `border-*-subtle` |
| **Typography** | `display-*`, `lead`, `fw-*`, `fs-*`, `list-unstyled`, `blockquote` |
| **Icons** | `{% sw_icon %}` (Shopware tag) |
| **Buttons** | `btn`, `btn-{variant}`, `btn-outline-{variant}`, `btn-sm`, `btn-lg`, `disabled`, `d-grid` |
| **Inputs** | `form-control`, `form-select`, `form-label`, `form-text`, `input-group`, `form-floating`, `is-valid`, `is-invalid`, `valid-feedback`, `invalid-feedback` |
| **Checkboxes** | `form-check`, `form-check-input`, `form-check-label`, `form-check-inline`, `form-switch` |
| **Alerts** | `alert`, `alert-{variant}`, `alert-dismissible`, `alert-heading`, `alert-link` |
| **Badges** | `badge`, `text-bg-{variant}`, `rounded-pill`, `position-absolute` counter badges |
| **Cards** | `card`, `card-header`, `card-body`, `card-footer`, `card-title`, `card-text`, `border-{variant}` |
| **Tables** | `table`, `table-striped`, `table-hover`, `table-bordered`, `table-sm`, `table-dark`, `table-light`, `table-responsive`, contextual row classes |
| **Pagination** | `pagination`, `page-item`, `page-link`, `pagination-sm/lg`, `justify-content-center/end` |

## Development

### Running Shopware locally

A Dockerised Shopware development environment is the easiest way to get started:

```bash
# Using the official Shopware Docker setup
git clone https://github.com/shopware/docker.git shopware-docker
cd shopware-docker
cp .env.dist .env
docker compose up -d
docker compose exec app bin/console plugin:refresh
docker compose exec app bin/console plugin:install --activate ShopwareDesignSystem
docker compose exec app bin/console theme:compile
```

### Watching SCSS changes

```bash
# From the Shopware project root
bin/console theme:dump
./node_modules/.bin/webpack --watch --config=var/theme-entry.js
```

### Clearing caches

```bash
bin/console cache:clear
bin/console http:cache:warm:up
```

## Contributing

Contributions are welcome! Please open an issue or pull request on GitHub.

1. Fork the repository
2. Create a feature branch: `git checkout -b feature/my-new-section`
3. Commit your changes: `git commit -m 'Add badge section'`
4. Push to your branch: `git push origin feature/my-new-section`
5. Open a pull request

## License

This plugin is released under the [MIT License](LICENSE).
