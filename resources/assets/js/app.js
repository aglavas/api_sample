
// Require bootstraping (jQuery etc..)
require('./bootstrap');

/**
 * Accordians
 * @param {*string[selector]} el 
 * @param {*boolen[multiple accordians opened]} multiple 
 */
let Accordion = (el, multiple) => {
    this.el = el || {};
	this.multiple = multiple || false;

    let links = this.el.find('.accordion-link');

    links.on('click', (e) => {
       
        let $el = this.el,
            $this = $(e.currentTarget),
            $sub = $this.next('.sub');
    
        $sub.slideToggle();

        $this.parent().toggleClass('open');

        if(!this.multiple){
            $el.find('.sub').not($sub).slideUp().parent().removeClass('open');
        }
        
    })
}

// Constructor
let accordion = new Accordion($('#accordions'), false);

/**
 * Get OS version for displaying links to app stores
 */
const getMobileOperatingSystem = () => {
  let userAgent = navigator.userAgent || navigator.vendor || window.opera;

    // Windows Phone must come first because its UA also contains "Android"
    if (/windows phone/i.test(userAgent)) {
        return "Windows Phone";
    }

    if (/android/i.test(userAgent)) {
        return "Android";
    }

    // iOS detection from: http://stackoverflow.com/a/9039885/177710
    if (/iPad|iPhone|iPod/.test(userAgent) && !window.MSStream) {
        return "iOS";
    }

    return "no-mobile";
}

console.log(getMobileOperatingSystem())