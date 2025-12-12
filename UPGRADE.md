# Upgrade Guide: ThemePack 3.x to 4.0

This guide will help you upgrade from ThemePack 3.x (Contao 4.x) to ThemePack 4.0 (Contao 5.3).

## Overview

ThemePack 4.0 is a major release that adds compatibility with Contao 5.3 LTS. This version includes breaking changes and requires a complete upgrade of your Contao installation.

## Requirements

### Before Upgrading

- **Current setup**: Contao 4.13.x + ThemePack 3.x
- **PHP**: 7.4 or 8.0
- **Backup**: Complete backup of database and files

### After Upgrading

- **Contao**: 5.3 LTS or higher
- **PHP**: 8.1 or higher (8.3 recommended)
- **ThemePack**: 4.0.0 or higher

## Pre-Upgrade Steps

### 1. Create Complete Backup

```bash
# Database backup
mysqldump -u username -p database_name > backup_$(date +%Y%m%d).sql

# Files backup
tar -czf files_backup_$(date +%Y%m%d).tar.gz files/
tar -czf templates_backup_$(date +%Y%m%d).tar.gz templates/
```

### 2. Document Current Configuration

Before upgrading, document:
- All custom templates in `/templates/`
- Image margin settings in content elements
- Custom CSS for ThemePack elements
- Module configurations

### 3. Test Environment

**Always test the upgrade on a development/staging environment first!**

## Upgrade Process

### Step 1: Upgrade Contao to 5.3

Follow the official Contao upgrade guide:
https://docs.contao.org/manual/en/installation/contao-update/

**Important**: Upgrade path must be:
- Contao 4.13 → **Contao 5.3** (direct upgrade path)

```bash
# Update Contao in composer.json
composer require contao/manager-bundle:5.3.* --no-update
composer update

# Clear cache
php vendor/bin/contao-console cache:clear
php vendor/bin/contao-console contao:migrate
```

### Step 2: Upgrade PHP to 8.1+

Ensure your server runs PHP 8.1 or higher. PHP 8.3 is recommended for best compatibility.

```bash
# Check PHP version
php -v
```

### Step 3: Upgrade ThemePack to 4.0

```bash
# Update ThemePack in composer.json
composer require sgn47gradnord/themepack:^4.0 --with-all-dependencies
composer update

# Clear all caches
php vendor/bin/contao-console cache:clear
php vendor/bin/contao-console cache:clear --env=prod

# Run database update
php vendor/bin/contao-console contao:migrate
```

### Step 4: Update Custom Templates

If you have custom ThemePack templates in `/templates/`, you need to update them:

#### Replace TL_MODE checks:

**Before (Contao 4.x)**:
```php
<?php if ('FE' === TL_MODE): ?>
    <!-- Frontend content -->
<?php endif; ?>

<?php if ('BE' === TL_MODE): ?>
    <!-- Backend content -->
<?php endif; ?>
```

**After (Contao 5.3)**:
```php
<?php if ($this->isFrontend): ?>
    <!-- Frontend content -->
<?php endif; ?>

<?php if ($this->isBackend): ?>
    <!-- Backend content -->
<?php endif; ?>
```

#### Fix undefined array keys:

**Before**:
```php
<?php if ($item['class']): ?>
    class="<?= $item['class'] ?>"
<?php endif; ?>
```

**After**:
```php
<?php if (!empty($item['class'])): ?>
    class="<?= $item['class'] ?>"
<?php endif; ?>
```

### Step 5: Update CSS for Image Margins

**Important**: The `imagemargin` field was removed in Contao 5.0.

#### Old Behavior (Contao 4.x)

Images had inline margin styles generated from the backend:
```html
<img src="..." style="margin: 10px 20px 10px 20px;">
```

#### New Behavior (Contao 5.3)

Margins must be handled via CSS classes:

**In Backend**:
- Use "Expert settings" → "CSS class" to add spacing classes
- Example: Add class `img-spacing` to content element

**In Your Stylesheet**:
```css
/* Add to your theme CSS */
.img-spacing {
    margin-top: 1rem;
    margin-bottom: 1rem;
}

.img-spacing.float_left {
    margin-right: 1rem;
}

.img-spacing.float_right {
    margin-left: 1rem;
}
```

#### Migration Strategy

1. **Identify all content elements** that used image margins
2. **Add CSS classes** to these elements in the backend
3. **Create CSS rules** in your theme stylesheet
4. **Test all pages** to ensure proper spacing

## Breaking Changes

### 1. Image Margins

- **Removed**: Backend `imagemargin` field functionality
- **Action**: Use CSS classes for image spacing

### 2. Template Variables

- **Removed**: Direct access to `TL_MODE` constant
- **Added**: `$this->isBackend` and `$this->isFrontend` template variables
- **Action**: Update custom templates (see Step 4)

### 3. PHP Version

- **Required**: PHP 8.1 minimum (8.3 recommended)
- **Action**: Upgrade server PHP version

### 4. Contao Version

- **Required**: Contao 5.3 LTS minimum
- **Action**: Follow Contao upgrade process first

## Post-Upgrade Checklist

After upgrading, verify the following:

### 1. Backend Access
- [ ] Backend loads without errors
- [ ] All ThemePack content elements appear in element picker
- [ ] Module settings can be edited

### 2. Frontend Rendering
- [ ] Homepage renders correctly
- [ ] Navigation menu works (no undefined array key warnings)
- [ ] Breadcrumb navigation works
- [ ] All content elements display correctly

### 3. Images
- [ ] Images load correctly
- [ ] Image sizing works (responsive images)
- [ ] Lightbox functionality works
- [ ] Image spacing is correct (via CSS)

### 4. Sliders
- [ ] Swiper Slider displays correctly
- [ ] Slider navigation works
- [ ] Slider auto-play works
- [ ] Video sliders work (MP4/WebM)

### 5. Layout Elements
- [ ] Container Start/Stop elements work
- [ ] Section Start/Stop elements work
- [ ] Column layouts display correctly

### 6. Special Features
- [ ] Feature boxes render correctly
- [ ] Parallax boxes work
- [ ] Gallery boxes display
- [ ] Text/Image boxes work

## Troubleshooting

### Issue: "Undefined constant TL_MODE"

**Solution**: Custom template still uses old constant. Update template:
```php
// Replace
<?php if ('FE' === TL_MODE): ?>

// With
<?php if ($this->isFrontend): ?>
```

### Issue: "Undefined array key 'class'"

**Solution**: Template needs PHP 8.3 compatibility fix:
```php
// Replace
<?php if ($item['class']): ?>

// With
<?php if (!empty($item['class'])): ?>
```

### Issue: "Class 'FilesModel' not found"

**Solution**: Clear all caches:
```bash
php vendor/bin/contao-console cache:clear
php vendor/bin/contao-console cache:clear --env=prod
composer dump-autoload -o
```

### Issue: Images have no margin/spacing

**Solution**: Add CSS classes for spacing (see Step 5)

### Issue: "TL_ASSETS_URL not defined"

**Solution**: Old custom template in `/templates/` needs update. Check if you have:
- `fe_page.html5`
- `js_themepack_setup.html5`

Replace with updated versions from bundle or update manually.

## Rollback Procedure

If you encounter critical issues and need to rollback:

### 1. Restore from Backup

```bash
# Restore database
mysql -u username -p database_name < backup_20241212.sql

# Restore files
tar -xzf files_backup_20241212.tar.gz
tar -xzf templates_backup_20241212.tar.gz
```

### 2. Downgrade Composer Packages

```bash
# Restore old composer.lock
git checkout composer.lock

# Install old versions
composer install

# Clear cache
php vendor/bin/contao-console cache:clear
```

## Support

If you encounter issues during the upgrade:

1. Check this upgrade guide thoroughly
2. Review the [CHANGELOG.md](CHANGELOG.md) for all changes
3. Check Contao 5.3 upgrade documentation: https://docs.contao.org/manual/en/installation/contao-update/
4. Contact 47GradNord support: info@47gradnord.de

## Additional Resources

- **Contao 5 Documentation**: https://docs.contao.org/5.x/
- **Contao 5 Migration Guide**: https://docs.contao.org/manual/en/installation/contao-update/
- **PHP 8.1 Migration Guide**: https://www.php.net/manual/en/migration81.php
- **PHP 8.3 Migration Guide**: https://www.php.net/manual/en/migration83.php

---

**Last Updated**: 2024-12-12
**Bundle Version**: 4.0.0
**Contao Version**: 5.3 LTS
