import 'bootstrap';
import 'bootstrap/css/bootstrap.css!';

var base = './';

export class App {
    configureRouter(config, router) {
        config.title = 'FBTB';
        config.map([
            {
                route: ['', 'news'],
                name: 'news',
                moduleId: base + 'news/news',
                nav: true,
                title: 'News'
            },
            {
                route: 'guide',
                name: 'guide',
                moduleId: base + 'guide/guide',
                nav: true,
                title: 'Flickr'
            },
            {
                route: 'flickr',
                name: 'flickr',
                moduleId: 'flickr/flickr',
                nav: true,
                title: 'Flickr'
            },
            {
                route: 'child-router',
                name: 'child-router',
                moduleId: base + 'demo/demo',
                nav: true,
                title: 'Child Router'
            }
    ]);

        this.router = router;
    }
}