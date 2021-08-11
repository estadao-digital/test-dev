import VanillaJSRouter from '../../node_modules/@daleighan/vanilla-js-router/index.js'

export const homeView = (element, data) => {

    let container = document.createElement('section')
    container.classList.add('cars-wrapper')
    element.appendChild(container)

    for (let i = 0; i < data.length; i++) {

        let article = document.createElement('article')
        container.appendChild(article)

        let header = document.createElement('header')
        article.appendChild(header)

        let span = document.createElement('span')
        span.innerHTML = data[i].id
        header.appendChild(span)

        let h4 = document.createElement('h4')
        h4.innerHTML = data[i].brand
        header.appendChild(h4)

        let section = document.createElement('section')
        article.appendChild(section)

        let h3 = document.createElement('h3')
        h3.innerHTML = data[i].model
        section.appendChild(h3)

        let footer = document.createElement('footer')
        article.appendChild(footer)

        let h5 = document.createElement('h5')
        h5.innerHTML = data[i].year
        footer.appendChild(h5)

        let showButton = document.createElement('button')
        showButton.classList.add('round-button')
        showButton.classList.add('show-button')
        showButton.onclick = () => window.router.goTo(`/car/${data[i].id}`)
        article.appendChild(showButton)

        let showIcon = document.createElement('i')
        showIcon.classList.add('fas')
        showIcon.classList.add('fa-eye')
        showButton.appendChild(showIcon)

        let updateButton = document.createElement('button')
        updateButton.classList.add('round-button')
        updateButton.classList.add('update-button')
        updateButton.onclick = () => window.router.goTo(`/edit/${data[i].id}`)
        article.appendChild(updateButton)

        let updateIcon = document.createElement('i')
        updateIcon.classList.add('fas')
        updateIcon.classList.add('fa-pen-nib')
        updateButton.appendChild(updateIcon)

        let deleteButton = document.createElement('button')
        deleteButton.classList.add('round-button')
        deleteButton.classList.add('delete-button')
        deleteButton.onclick = () => window.router.goTo(`/delete/${data[i].id}`)
        article.appendChild(deleteButton)

        let deleteIcon = document.createElement('i')
        deleteIcon.classList.add('fas')
        deleteIcon.classList.add('fa-trash-alt')
        deleteButton.appendChild(deleteIcon)

    }
}
