export class App {
    configureRouter(config, router) {
        config.title = 'Aurelia';
        config.map([
            {
                route: ['', 'home'],
                name: 'home',
                moduleId: 'welcome',
                nav: true,
                title: 'Welcome'
            },

            {
                route: 'articles',
                name: 'articles',
                moduleId: 'articles',
                nav: true,
                title: 'Articles'
            },
            {
                route: 'reviews',
                name: 'reviews',
                moduleId: 'reviews',
                nav: true,
                title: 'Reviews'
            },
            {
                route: 'about',
                name: 'about',
                moduleId: 'about',
                nav: false,
                title: 'About'
            }
    ]);

        this.router = router;
    }
}