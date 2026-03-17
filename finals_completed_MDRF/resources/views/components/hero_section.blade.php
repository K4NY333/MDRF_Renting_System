<style>
       /* Place this in your <style> section */
html, body {
    scroll-behavior: smooth;
}
.hero-section {
    z-index: 1000;
    min-height: 100vh;
    width: 100%;
    background: linear-gradient(135deg, #eab566 0%, #a2854b 100%);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    position: relative;
    overflow: hidden;
    text-align: center;
}
.imglogooo {
    width: 30%;
    height: 30%;
    object-fit: contain;
    margin-bottom: 0;      /* Remove space below the image */
    display: fixed;
    margin-bottom: 90px;
}
.mascot{
    position: fixed;
    bottom: 30px;
    right: 10px
}
 
.hero-desc {
    font-size: 1.3rem;
    color: #fffbe9;
    margin-top: 0.5rem;    /* Optional: slight space above desc */
    margin-bottom: 2.5rem;
    font-weight: 400;
    z-index: 10;
    position: fixed;
    bottom: 36%;
}
.hero-scroll-btn {
    background: #8b7355;
    color: #fff;
    border: none;
    border-radius: 50px;
    padding: 1rem 2.5rem;
    font-size: 1.2rem;
    font-weight: 600;
    cursor: pointer;
    box-shadow: 0 4px 24px rgba(139, 115, 85, 0.12);
    transition: background 0.2s;
    margin-bottom: 1.5rem;
}
.hero-scroll-btn:hover {
    background: #a2854b;
}
.hero-arrow {
    display: block;
    margin: 2.5rem auto 0 auto;
    font-size: 2.5rem;
    color: #fff;
    animation: bounce 1.5s infinite;
}
@keyframes bounce {
    0%, 100% { transform: translateY(0);}
    50% { transform: translateY(18px);}
}
 
.mascot {
    position: fixed;
    bottom: 30px;
    right: 10px;
    cursor: pointer;
}
 
/* Thinkbox styling */
.thinkbox {
    position: fixed;
    right: 180px;   /* Increase to move more left, decrease to move more right */
    bottom: 458px;  /* Increase to move higher, decrease to move closer to mascot */
    z-index: 20;
    display: flex;
    flex-direction: column;
    align-items: center;
    pointer-events: none;
    display: none;
}
 
.mascot:hover + .thinkbox,
.mascot:focus + .thinkbox {
    display: flex;
}
.thinkbox-bubble {
    background: #fffbe9;
    color: #a2854b;
    border-radius: 30px;
    padding: 0.7em 1.3em;
    font-size: 1.5rem;
    font-weight: bold;
    width: 300px;
    height: 100px;
    margin-right:40px;
    box-shadow: 0 2px 12px rgba(139, 115, 85, 0.15);
    animation: pop-in 0.7s cubic-bezier(.4,0,.2,1);
}
@keyframes bubble-bounce{
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-18px); }
}
@keyframes pop-in {
    0% { transform: scale(0.7); opacity: 0; }
    80% { transform: scale(1.1); opacity: 1; }
    100% { transform: scale(1); opacity: 1; }
}
.thinkbox-dot {
    width: 12px;
    height: 12px;
    background: #fffbe9;
    border-radius: 50%;
    opacity: 0.8;
    animation: dot-bounce 1.2s infinite;
    position: static;
    margin-top: 8px;
    margin-left: 250px;
}
.thinkbox-dot.dot1 { animation-delay: 0s; }
.thinkbox-dot.dot2 { animation-delay: 0.2s; }
.thinkbox-dot.dot3 { animation-delay: 0.4s; }
 
@keyframes dot-bounce {
    0%, 100% { transform: translateY(0);}
    50% { transform: translateY(-10px);}
}
</style>
 
<body>
 
<!-- Hero Section -->
<section class="hero-section" id="hero">
    <img src="{{ asset('assets/sample-logo.png') }}" alt="MDRF Logo" class="imglogooo">
    <div class="hero-desc">Find your next home or list your property with ease.<br>Modern, Secure, and Hassle-Free Apartment Rentals.</div>
    <button class="hero-scroll-btn" onclick="document.getElementById('mainContent').scrollIntoView({behavior:'smooth'})">
        Get Started
    </button>
    <span class="hero-arrow"><i class="fas fa-angle-double-down"></i></span>
    <img src="{{ asset('assets/mascot-transparent.png') }}" class="mascot">
   
    <!-- Animated thinkbox above mascot -->
    <div class="thinkbox">
        <div class="thinkbox-bubble">Welcome</div>
        <div class="thinkbox-dot dot1"></div>
        <div class="thinkbox-dot dot2"></div>
        <div class="thinkbox-dot dot3"></div>
    </div>
</section>
 
<script>
window.addEventListener('DOMContentLoaded', function() {
    const hero = document.getElementById('hero');
    const headerContent = document.querySelector('.header-content');
    // Always show hero and hide header-content on load
    if (hero) {
        hero.style.display = '';
        hero.style.opacity = '1';
        hero.style.transform = 'none';
        hero.style.pointerEvents = 'auto';
    }
    if (headerContent) {
        headerContent.style.opacity = '0';
        headerContent.style.transform = 'translateY(60px)';
    }
    window.heroHidden = false;
});
 
function hideHeroAndRevealHeader() {
    const hero = document.getElementById('hero');
    const headerContent = document.querySelector('.header-content');
    if (!window.heroHidden && hero && headerContent) {
        window.heroHidden = true;
        hero.style.transition = 'opacity 0.7s cubic-bezier(.4,0,.2,1), transform 0.7s cubic-bezier(.4,0,.2,1)';
        hero.style.opacity = '0';
        hero.style.transform = 'translateY(-95vh)';
        hero.style.pointerEvents = 'none';
        // Animate header-content in
        headerContent.style.transition = 'opacity 0.7s cubic-bezier(.4,0,.2,1), transform 0.7s cubic-bezier(.4,0,.2,1)';
        headerContent.style.opacity = '1';
        headerContent.style.transform = 'translateY(0)';
        setTimeout(() => {
            hero.style.display = 'none';
        }, 700);
    }
}
 
document.addEventListener('DOMContentLoaded', function() {
    const btn = document.querySelector('.hero-scroll-btn');
    if (btn) {
        btn.addEventListener('click', function(e) {
            hideHeroAndRevealHeader();
        });
    }
});
 
window.addEventListener('scroll', function() {
    const hero = document.getElementById('hero');
    if (window.scrollY > 30 && hero && !window.heroHidden) {
        hideHeroAndRevealHeader();
    }
});
</script>