if(window.screen.width > 1100){
    function parallax(event) {
        this.querySelectorAll('.parallax-img').forEach(parallax => {
            let speed = parallax.getAttribute('data-speed');
            parallax.style.transform = `translateX(${event.clientX * speed / 1000}px)`;
        });
    }
    
    document.addEventListener('mousemove', parallax);
    
    let hills1 = document.getElementById('hills1');
    let hills2 = document.getElementById('hills2');
    let hills3 = document.getElementById('hills3');
    let text = document.getElementById('text');
    let hills4 = document.getElementById('hills4');
    
    window.addEventListener('scroll', () => {
        let value = window.scrollY;
        hills1.style.top = value / -70 + '%';
        hills2.style.top = value / -190 + '%';
        hills3.style.top = value / -70   + '%';
        text.style.top = value  / -35 + '%';
        hills4.style.top = value / -200 + '%';
    });
}
