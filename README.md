Facebook Tab Template
===

An awesome boilerplate template for creating basic Facebook Tabs. Based on HTML5 Boilerplate (v3.0.2):
http://html5boilerplate.com

Pull requests are encouraged.

Usage
---

Create your Facebook application and setup proper URLs here:
https://developers.facebook.com/apps

Grab your app ID and toss it in `index.html`

If you need a signed request, checkout the `php` branch and plug your app ID and secret into the top of the index.php file.

Enjoy.

Included
---

### Javascript
- jQuery 1.7.2
- Facebook Javascript SDK
- Google Analytics

### CSS
- HTML5 Boilerplate reset, based on normalize.css

### HTML
- Open Graph meta tags

### Rakefile
- Plug your server information in and run the associated rake commands `rake deploy`, `rake fake`, etc.

### Fixes
- FB.Canvas.setAutoGrow for resizing tab size automatically
- IE HTML classes
- Use log() for cross-browser console.log()