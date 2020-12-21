/* A polyfill for browsers that don't support ligatures. */
/* The script tag referring to this file must be placed before the ending body tag. */

/* To provide support for elements dynamically added, this script adds
   method 'icomoonLiga' to the window object. You can pass element references to this method.
*/
(function () {
    'use strict';
    function supportsProperty(p) {
        var prefixes = ['Webkit', 'Moz', 'O', 'ms'],
            i,
            div = document.createElement('div'),
            ret = p in div.style;
        if (!ret) {
            p = p.charAt(0).toUpperCase() + p.substr(1);
            for (i = 0; i < prefixes.length; i += 1) {
                ret = prefixes[i] + p in div.style;
                if (ret) {
                    break;
                }
            }
        }
        return ret;
    }
    var icons;
    if (!supportsProperty('fontFeatureSettings')) {
        icons = {
            'home': '&#xe900;',
            'house': '&#xe900;',
            'image': '&#xe90d;',
            'picture': '&#xe90d;',
            'price-tags': '&#xe936;',
            'cart': '&#xe93a;',
            'purchase': '&#xe93a;',
            'calculator': '&#xe940;',
            'compute': '&#xe940;',
            'calendar': '&#xe953;',
            'date': '&#xe953;',
            'user': '&#xe971;',
            'profile2': '&#xe971;',
            'search': '&#xe986;',
            'magnifier': '&#xe986;',
            'zoom-in': '&#xe987;',
            'magnifier2': '&#xe987;',
            'equalizer': '&#xe992;',
            'sliders': '&#xe992;',
            'stats-dots': '&#xe99b;',
            'stats2': '&#xe99b;',
            'stats-bars2': '&#xe99d;',
            'stats4': '&#xe99d;',
            'earth': '&#xe9ca;',
            'globe2': '&#xe9ca;',
            'plus': '&#xea0a;',
            'add': '&#xea0a;',
            'info': '&#xea0c;',
            'information': '&#xea0c;',
            'cancel-circle': '&#xea0d;',
            'close': '&#xea0d;',
            'checkmark': '&#xea10;',
            'tick': '&#xea10;',
            'enter': '&#xea13;',
            'signin': '&#xea13;',
            'exit': '&#xea1b;',
            'signout': '&#xea1b;',
            'arrow-right2': '&#xea3c;',
            'right4': '&#xea3c;',
            'arrow-left2': '&#xea40;',
            'left4': '&#xea40;',
            'table': '&#xea70;',
            'wysiwyg18': '&#xea70;',
            'mail2': '&#xea83;',
            'contact2': '&#xea83;',
            'facebook2': '&#xea91;',
            'brand11': '&#xea91;',
            'instagram': '&#xea92;',
            'brand12': '&#xea92;',
            'twitter': '&#xea96;',
            'brand16': '&#xea96;',
            'dropbox': '&#xeaae;',
            'brand38': '&#xeaae;',
            'onedrive': '&#xeaaf;',
            'brand39': '&#xeaaf;',
            'linkedin': '&#xeac9;',
            'brand64': '&#xeac9;',
            'file-pdf': '&#xeadf;',
            'file10': '&#xeadf;',
          '0': 0
        };
        delete icons['0'];
        window.icomoonLiga = function (els) {
            var classes,
                el,
                i,
                innerHTML,
                key;
            els = els || document.getElementsByTagName('*');
            if (!els.length) {
                els = [els];
            }
            for (i = 0; ; i += 1) {
                el = els[i];
                if (!el) {
                    break;
                }
                classes = el.className;
                if (/icon-/.test(classes)) {
                    innerHTML = el.innerHTML;
                    if (innerHTML && innerHTML.length > 1) {
                        for (key in icons) {
                            if (icons.hasOwnProperty(key)) {
                                innerHTML = innerHTML.replace(new RegExp(key, 'g'), icons[key]);
                            }
                        }
                        el.innerHTML = innerHTML;
                    }
                }
            }
        };
        window.icomoonLiga();
    }
}());
