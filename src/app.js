import {
    Router
}
from 'aurelia-router';

var base = './';

export class App {
    static inject() {
        return [Router];
    }
    constructor(router) {
        this.router = router;
        this.router.configure(config => {
            config.title = 'FBTB';
            config.map([
                { route: ['', 'articles'], name: 'news', moduleId: base + 'news/news', nav: true, title: 'News' },
                { route: 'articles/:type', name: 'reviews', moduleId: base + 'news/news', nav: true, title: 'Reviews' },
                { route: 'article/:type', name: 'news', moduleId: base + 'news/news', nav: true, title: 'Articles' },
                { route: 'guide', name: 'guide', moduleId: base + 'guide/guide', nav: true, title: 'Guide' },
                { route: 'community', name: 'community', moduleId: 'communit/communit', nav: true, title: 'Community' },
                { route: 'child-router', name: 'child-router', moduleId: base + 'demo/demo', nav: false, title: 'Child Router' }
          ]);
        })
    }
}