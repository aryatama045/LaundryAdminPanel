<style>
  *,
*::after,
*::before {
	box-sizing: border-box;
}

:root {
	font-size: 15px;
}

body {
	margin: 0;
	--color-text: #000;
	--color-bg-view-1: #f3efe6;
	--color-bg-view-2: #cbb37e;
	--color-link: #000;
	--color-link-hover: #000;
	--color-button: #000;
	--color-button-hover: #634c18;
	color: var(--color-text);
	background-color: var(--color-bg-view-1);
	font-family: -apple-system, BlinkMacSystemFont, Segoe UI, Helvetica, Arial, sans-serif;
	font-weight: 500;
	-webkit-font-smoothing: antialiased;
	-moz-osx-font-smoothing: grayscale;
	overflow: hidden;
}

a {
	text-decoration: none;
	color: var(--color-link);
	outline: none;
}

a:hover {
	color: var(--color-link-hover);
	outline: none;
}

/* Better focus styles from https://developer.mozilla.org/en-US/docs/Web/CSS/:focus-visible */
a:focus {
	/* Provide a fallback style for browsers
	 that don't support :focus-visible */
	outline: none;
	background: lightgrey;
}

a:focus:not(:focus-visible) {
	/* Remove the focus indicator on mouse-focus for browsers
	 that do support :focus-visible */
	background: transparent;
}

a:focus-visible {
	/* Draw a very noticeable focus style for
	 keyboard-focus on browsers that do support
	 :focus-visible */
	outline: 2px solid #fff;
	background: transparent;
}

.unbutton {
	background: none;
	border: 0;
	padding: 0;
	margin: 0;
	font: inherit;
	cursor: pointer;
}

.unbutton:focus {
	outline: none;
}

main {
	display: grid;
	grid-template-columns: 100%;
	grid-template-rows: 100vh;
}

.frame {
	grid-area: 1 / 1 / 2 / 2;
	padding: 1.5rem 2rem 10vh;
	text-align: center; 
	position: relative;
	z-index: 100;
	pointer-events: none;
}

.frame a {
	pointer-events: auto;
}

.frame__title {
	margin: 0;
	font-size: 1rem;
	font-weight: 500;
}

.frame__links {
	margin: 0.5rem 0 2rem;
}

.frame__links a:not(:last-child) {
	margin-right: 1rem;
}

.button {
	color: var(--color-button);
	border-radius: 30px;
	min-width: 150px;
	padding: 1rem 2rem;
	border: 1px solid currentColor;
}

.button:hover,
.button:focus-visible {
	color: var(--color-button-hover);
}

.frame--view-open .button-open {
	opacity: 0;
	pointer-events: none;
}

.view {
	position: relative;
	grid-area: 1 / 1 / 2 / 2;
	display: grid;
	place-items: center;
}

.view--2 {
	background: var(--color-bg-view-2);
	pointer-events: none;
	opacity: 0;
}

.view.view--open {
	pointer-events: auto;
	opacity: 1;
}

.overlay {
	grid-area: 1 / 1 / 2 / 2;
	position: relative;
	z-index: 1000;
	pointer-events: none;
	width: 100%;
	height: 100%;
}

@media screen and (min-width: 53em) {
	.frame {
		padding: 1.5rem 2rem 0;
		display: grid;
		grid-template-columns: auto 1fr auto;
		grid-template-areas: 'title links sponsor';
		grid-gap: 3vw;
		justify-content: space-between;
		text-align: left;
	}
	.frame__links {
		margin: 0;
	}
}
</style>


<main>
    <div class="frame">
        <h1 class="frame__title">Sketch 021: SVG Path Page Transition (Vertical)</h1>
        <nav class="frame__links"><a href="https://github.com/codrops/codrops-sketches/tree/main/021-svg-path-page-transition-vertical">GitHub</a>
            <a href="https://tympanus.net/codrops/sketches">Archive</a>
        </nav>
    </div>
    <div class="view view--1">
        <button class="unbutton button button--open" aria-label="Open other view">Open</button>
    </div>
    <div class="view view--2">
        <button class="unbutton button button--close" aria-label="Close current view">Back</button>
    </div>
    <!-- From https://codepen.io/sebastien-gilbert/pen/VwLzvGV?editors=1010 -->
    <!-- Edit the paths here: https://yqnn.github.io/svg-path-editor/ -->
    <svg class="overlay" width="100%" height="100%" viewBox="0 0 100 100" preserveAspectRatio="none">
        <path class="overlay__path" vector-effect="non-scaling-stroke" d="M 0 100 V 100 Q 50 100 100 100 V 100 z" />
    </svg>
</main>





<script>
    // frame element
const frame = document.querySelector('.frame');

// overlay (SVG path element)
const overlayPath = document.querySelector('.overlay__path');

// paths
// edit here: https://yqnn.github.io/svg-path-editor/
const paths = {
    step1: {
        unfilled: 'M 0 100 V 100 Q 50 100 100 100 V 100 z',
        inBetween: {
            curve1: 'M 0 100 V 50 Q 50 0 100 50 V 100 z',
            curve2: 'M 0 100 V 50 Q 50 100 100 50 V 100 z'
        },
        filled: 'M 0 100 V 0 Q 50 0 100 0 V 100 z',
    },
    step2: {
        filled: 'M 0 0 V 100 Q 50 100 100 100 V 0 z',
        inBetween: {
            curve1: 'M 0 0 V 50 Q 50 0 100 50 V 0 z',
            curve2: 'M 0 0 V 50 Q 50 100 100 50 V 0 z'
        },
        unfilled: 'M 0 0 V 0 Q 50 0 100 0 V 0 z',
    }
};

// landing page/content element 
const landingEl = document.querySelector('.view--2');

// transition trigger button
const switchCtrl = document.querySelector('button.button--open');

// back button
const backCtrl = landingEl.querySelector('.button--close');

let isAnimating = false;

let page = 1;

// reveals the second content view
const reveal = ()  => {
    
    if ( isAnimating ) return;
    isAnimating = true;

    page = 2;
    
    gsap.timeline({
            onComplete: () => isAnimating = false
        })
        .set(overlayPath, {
            attr: { d: paths.step1.unfilled }
        })
        .to(overlayPath, { 
            duration: 0.8,
            ease: 'power4.in',
            attr: { d: paths.step1.inBetween.curve1 }
        }, 0)
        .to(overlayPath, { 
            duration: 0.2,
            ease: 'power1',
            attr: { d: paths.step1.filled },
            onComplete: () => switchPages()
        })

        .set(overlayPath, { 
            attr: { d: paths.step2.filled }
        })
        
        .to(overlayPath, { 
            duration: 0.2,
            ease: 'sine.in',
            attr: { d: paths.step2.inBetween.curve1 }
        })
        .to(overlayPath, { 
            duration: 1,
            ease: 'power4',
            attr: { d: paths.step2.unfilled }
        });
}

const switchPages = () => {
    if ( page === 2 )Â {
        frame.classList.add('frame--view-open');
        landingEl.classList.add('view--open');
    }
    else {
        frame.classList.remove('frame--view-open');
        landingEl.classList.remove('view--open');
    }
}

// back to first content view
const unreveal = ()  => {
    
    if ( isAnimating ) return;
    isAnimating = true;

    page = 1;

    gsap.timeline({
            onComplete: () => isAnimating = false
        })
        .set(overlayPath, {
            attr: { d: paths.step2.unfilled }
        })
        .to(overlayPath, { 
            duration: 0.8,
            ease: 'power4.in',
            attr: { d: paths.step2.inBetween.curve2 }
        }, 0)
        .to(overlayPath, { 
            duration: 0.2,
            ease: 'power1',
            attr: { d: paths.step2.filled },
            onComplete: () => switchPages()
        })
        // now reveal
        .set(overlayPath, { 
            attr: { d: paths.step1.filled }
        })
        .to(overlayPath, { 
            duration: 0.2,
            ease: 'sine.in',
            attr: { d: paths.step1.inBetween.curve2 }
        })
        .to(overlayPath, { 
            duration: 1,
            ease: 'power4',
            attr: { d: paths.step1.unfilled }
        });
}

// click on menu button
switchCtrl.addEventListener('click', reveal);
// click on close menu button
backCtrl.addEventListener('click', unreveal);
</script>