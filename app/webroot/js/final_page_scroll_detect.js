let debugging = true;
let lastScrollTop = window.pageYOffset;
let scrollingDown = false;
let interactedContent = [];
let inViewContent = [];
let sections = [];
let sectionMapping = {
    "summary": "Results summary",
    "score": "Results score",
    "score-range": "Results score range",
    "compare": "Results comparison",
    "bac": "Results BAC",
    "did-you-know": "Results: did you know?",
    "spend": "Results spending"
}

// window.addEventListener('beforeunload', function() {
//     console.log('before unload');
//     // Cancel the event
//     e.preventDefault(); // If you prevent default behavior in Mozilla Firefox prompt will always be shown
//     // Chrome requires returnValue to be set
//     e.returnValue = '';
// });

document.addEventListener('DOMContentLoaded', function () {
    sections = $('section.accordian > div.acc-content > section > h3').parent().add($('.support-info > div.contact-group')).add($('fieldset > section'));
    $("a.btn.pdf").on("click", function () {
        interactedContent.push(
            (getFormattedDate() + " - " + "Download as PDF")
        );
    });
    captureSectionsInView();
});

window.addEventListener('scroll', function () {
    captureSectionsInView();
});

// Create helper div that shows percentage visible for each section element
if (debugging) {
    var info = document.getElementById('info');
    document.addEventListener('DOMContentLoaded', function () { 
        createDebuggingPanel(); 
        updateElementVisibilityInfo(); 
    });
    window.addEventListener('scroll', () => updateElementVisibilityInfo());
}

var captureSectionsInView = function () {
    setScrollDirection();

    for (let index = 0; index < sections.length; index++) {
        const element = sections[index];
        const sectionTitle = getElementTitle(element);
        const visiblePortion = getVisiblePortion(element);

        // Skip element if the section is unexpanded
        if (!$(element).parents("section.accordian").hasClass("active") && !$(element).parents("section").hasClass("questions")) continue;

        if (isInView(visiblePortion, 30)) {
            if (!containElement(inViewContent, sectionTitle)) {
                inViewContent.push(sectionTitle);
                interactedContent.push(
                    (getFormattedDate() + " - " + sectionTitle.replaceAll('"', ""))
                );
                // send AJAX
                console.log(JSON.stringify(interactedContent));
            }
        } else {
            if (containElement(inViewContent, sectionTitle)) {
                let indexToRemove = inViewContent.indexOf(sectionTitle);
                inViewContent.splice(indexToRemove, 1);
            }
        }
    }
}

var containElement = function (list, identifier) {
    return list.indexOf(identifier) >= 0;
}

var getElementTitle = function (element) {
    return $(element).children("h3")[0]?.innerText ?? $(element).children("h4")[0]?.innerText ?? sectionMapping[$(element).attr('class').split(' ')[0]];
}

var getFormattedDate = function () {
    return window.performance.now()
}

var getVisiblePortion = function (element) {
    var position = element.getBoundingClientRect();
    var visiblePortion = 0;

    if (position.top >= 0 && position.bottom <= window.innerHeight) { // If fully visible
        visiblePortion = 100;
        inView = true;
    } else if (position.top < window.innerHeight && position.bottom >= 0) { // If partially visible
        if (position.bottom > window.innerHeight) { // entering view on scrolldown, or leaving view on scroll up
            let amountShowing = window.innerHeight - position.top;
            visiblePortion = parseInt(100 * (amountShowing / position.height));
        } else { // leaving view on scroll down, or entering view on scroll up
            let amountShowing = position.bottom;
            visiblePortion = parseInt(100 * (amountShowing / position.height));
        }
    } else {
        visiblePortion = 0;
    }

    return visiblePortion;
}

var isInView = function (visiblePortion, threshold) {
    return visiblePortion >= threshold;
}

var setScrollDirection = function () {
    var st = window.pageYOffset || document.documentElement.scrollTop; // Credits: "https://github.com/qeremy/so/blob/master/so.dom.js#L426"
    if (st > lastScrollTop) {
        scrollingDown = true;
    } else {
        scrollingDown = false;
    }
    lastScrollTop = st <= 0 ? 0 : st;
}


/// Debugging helpers
var createDebuggingPanel = function () {
    $('<div id="info" style="align-items:center; background-color:white; color:black; display:flex; flex-direction:column; justify-content:center; position:fixed; right:30px; top:10px; width:400px; z-index:1" bgcolor="white" width="400"></div>').insertAfter(".survey.wrap.results>p.title");

    for (let index = 0; index < sections.length; index++) {
        const element = sections[index];
        const sectionTitle = getElementTitle(element);
        const p = document.createElement("P");
        const txt = document.createTextNode(sectionTitle + " percent: %");

        p.id = sectionTitle;
        p.appendChild(txt);
        document.getElementById('info').appendChild(p);
    }
}

var updateElementVisibilityInfo = function () {
    for (let index = 0; index < sections.length; index++) {
        const element = sections[index];
        const sectionTitle = getElementTitle(element);
        const visiblePortion = getVisiblePortion(element);

        // Skip element if the section is unexpanded
        if (!$(element).parents("section.accordian").hasClass("active") && !$(element).parents("section").hasClass("questions")) continue;

        document.getElementById(sectionTitle).innerText = sectionTitle + " percent: " + visiblePortion + "%";
    }
}
