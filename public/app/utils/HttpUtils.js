
export const loadTemplate = (path, callback) => {
    fetch(path)
        .then(response => response.text())
        .then(template => callback(template))
}

export const lazyLoad = (component, resolve) => {
    import(`/public/app/pages/${component}`).then(response => resolve(response.default));
}
