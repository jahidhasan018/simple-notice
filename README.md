# Simple Notice

Simple Notice is a lightweight WordPress plugin that shows a configurable notice on the front end of your site. Visitors can dismiss it automatically or manually, and you can control where and how it appears.

## Features

- Enable/disable the notice globally.
- Display on all pages or a specific page/post.
- Auto-hide or click-to-hide behavior with configurable delay.
- Multiple position and style options.
- Cookie-based suppression (show again after a number of days).
- Optional “hide on mobile” toggle.
- Shortcode to trigger notices from buttons/links.
- Gutenberg block for inserting notice buttons in the editor.

## Usage

1. Go to **Settings → Simple Notice**.
2. Configure the notice text, display rules, and styling.
3. Save your settings.

### Shortcode

Use the shortcode below to trigger a notice from a button:

```
[smn_notice_btn text="My button" hide="auto" position="top center" style="bootstrap"]
```

**Shortcode attributes**

- `text`: Button label and notice text.
- `url`: Button link URL (default: `#`).
- `class`: Custom CSS class for the button.
- `hide`: `auto` or `click`.
- `position`: One of the positions from the settings page.
- `style`: `bootstrap`, `happyblue`, or `blackBg`.

### Gutenberg block

Use the **Simple Notice Button** block from the Widgets category to insert a notice-triggering button with the same options as the shortcode.

## Testing

Install dev dependencies and run PHPUnit:

```
composer install
composer test
```
