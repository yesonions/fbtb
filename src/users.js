import { inject } from 'aurelia-framework';
import { HttpClient } from 'aurelia-fetch-client';
import 'fetch';

@inject(HttpClient)
export class Posts {
    heading = 'Posts';
    title = {
        rendered: ''
    };
    content = {
        rendered: ''
    };
  


    params = 'post_status=publish&page=1&filter[posts_per_page]=10';
    posts = [];

    constructor(http) {
        http.configure(config => {
            config
                .useStandardConfiguration()
                .withBaseUrl('http://content.nickmartin.us/wp-json/wp/v2/posts?' + this.params);
        });

        this.http = http;
    }

    activate() {
        return this.http.fetch('posts')
            .then(response => response.json())
            .then(users => this.users = users);
    }
}