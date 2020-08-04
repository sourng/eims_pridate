function UrlHelper() {
    this.set = (data, url) => {
        if (typeof history.pushState == "function") {
            history.pushState(data, null, url);
        }
    }
}
