if (!localStorage.getItem('darkmode')) {
    localStorage.setItem('darkmode', 'off')
}
let darkmode = localStorage.getItem('darkmode')
if (darkmode === 'on') {
    let body = document.body;
    body.classList.add("dark")
}


function darkToggle() {
    if (!localStorage.getItem('darkmode')) {
        localStorage.setItem('darkmode', 'on')

    } else {
        let darkmode = localStorage.getItem('darkmode')
        if (darkmode === 'on') {
            darkmode = 'off'
        } else if (darkmode === 'off') {
            darkmode = 'on'
        }
        localStorage.setItem('darkmode', darkmode)
    }
    let body = document.body;
    body.classList.toggle("dark");

}