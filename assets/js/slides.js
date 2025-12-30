// Akses gambar
let slideImages = document.querySelectorAll('.slides img')
// Akses tombol
const next = document.querySelector('.next')
const prev = document.querySelector('.prev')
// Akses indikator
dots = document.querySelectorAll('.dot')

let counter = 0
function setCounter(value) {
    counter = value
    updateIndicator()
}

// function nextSlide
next.addEventListener('click', slideNext)
function slideNext() {
    let current = counter
    slideImages[current].style.animation = 'next1 .5s ease-in forwards'
    if(current >= slideImages.length - 1) {
        setCounter(0)
    } else {
        setCounter(current + 1)
    }
    slideImages[counter].style.animation = 'next2 .5s ease-in forwards'
}

// function prevSlide
prev.addEventListener('click', slidePrev)
function slidePrev() {
    let current = counter
    slideImages[current].style.animation = 'prev1 .5s ease-in forwards'
    if(current == 0) {
        setCounter(slideImages.length - 1) 
    } else {
        setCounter(current - 1)
    }
    slideImages[counter].style.animation = 'prev2 .5s ease-in forwards'
}

// function autoSlide
let deleteInterval = null
function autoSlide() {
    deleteInterval = setInterval(timer, 5000);
    function timer() {
        slideNext()
    }
}
autoSlide()

// stop and resume autoslide on mouseover and mouseout
const container = document.querySelector('.slide-container')
container.addEventListener('mouseover', () => {
    clearInterval(deleteInterval)
})

container.addEventListener('mouseout', () => {
    autoSlide()
})

// function setActive indicator
function updateIndicator() {
    dots.forEach(dot => dot.classList.remove('active'))
    dots[counter].classList.add('active')
}

// onclick pada indicator
container.addEventListener('click', function(e) {
    target = e.target
    if(target.classList.contains('dot')) {
        switchImage(target)
    }
})

function switchImage(dot) {
    const imageId = parseInt(dot.dataset.id)
    let current = counter
    
    if(imageId === current) return

    if(imageId > current) {
        slideImages[current].style.animation = 'next1 .5s ease-in forwards'
    } else {
        slideImages[current].style.animation = 'prev1 .5s ease-in forwards'
    }
    
    setCounter(imageId)

    if(imageId > current) {
        slideImages[imageId].style.animation = 'next2 .5s ease-in forwards'
    } else {
        slideImages[imageId].style.animation = 'prev2 .5s ease-in forwards'
    }
}