# Login Design Switcher

This project now has multiple login designs available. Use the commands below to switch between them.

## Available Designs

### Design #1 (Blue/Purple Theme)
- **Colors**: Blue to Purple gradient
- **Style**: Professional with subtle animations
- **File**: `login-design-1.blade.php`

### Design #2 (Emerald/Teal Theme) - CURRENT
- **Colors**: Emerald to Teal gradient
- **Style**: Modern with enhanced animations (bounce, ping, pulse)
- **File**: `login.blade.php` (current active design)

## How to Switch Designs

### To use Design #1 (Blue/Purple):
```bash
cp resources/views/auth/login-design-1.blade.php resources/views/auth/login.blade.php
npm run build
```

### To use Design #2 (Emerald/Teal):
This is currently active. If you need to restore it:
```bash
# Design #2 is already in the main login.blade.php file
npm run build
```

## Design Features Comparison

| Feature | Design #1 | Design #2 |
|---------|-----------|-----------|
| Color Scheme | Blue → Purple → Indigo | Emerald → Teal → Cyan |
| Icon Animation | Simple pulse | Pulse + rotation |
| Background Elements | 4 floating circles | 6 floating circles |
| Animation Types | Pulse only | Bounce, ping, pulse |
| Feature List Animation | None | Hover slide effect |
| Button Hover | Scale 1.02 | Scale 1.03 |
| Icon Container | Rounded-2xl | Rounded-3xl |

## Quick Commands

```bash
# Switch to Design #1
echo "Switching to Design #1 (Blue/Purple)"
cp resources/views/auth/login-design-1.blade.php resources/views/auth/login.blade.php
npm run build

# Switch to Design #2
echo "Switching to Design #2 (Emerald/Teal)"
git checkout resources/views/auth/login.blade.php
npm run build
```

Both designs maintain the same:
- "Streamline Your HR Operations" heading
- Same 4 feature points
- Mobile responsiveness
- Form functionality
- Professional layout