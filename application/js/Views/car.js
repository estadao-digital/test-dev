export const carView = (element, data) => {

    let container = document.createElement('section')
    container.classList.add('car-wrapper')
    element.appendChild(container)

    let article = document.createElement('article')
    container.appendChild(article)

    let header = document.createElement('header')
    article.appendChild(header)

    let span = document.createElement('span')
    span.innerHTML = data.id
    header.appendChild(span)

    let h4 = document.createElement('h4')
    h4.innerHTML = data.brand
    header.appendChild(h4)

    let section = document.createElement('section')
    article.appendChild(section)

    let h3 = document.createElement('h3')
    h3.innerHTML = data.model
    section.appendChild(h3)

    let footer = document.createElement('footer')
    article.appendChild(footer)

    let h5 = document.createElement('h5')
    h5.innerHTML = data.year
    footer.appendChild(h5)

    let buttonContainer = document.createElement('div')
    buttonContainer.classList.add('button-container')
    element.appendChild(buttonContainer)

    let button = document.createElement('button')
    button.classList.add('button')
    button.innerHTML = 'Voltar'
    button.onclick = () => window.router.goTo('/')
    buttonContainer.appendChild(button)
}
