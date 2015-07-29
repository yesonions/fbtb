import { computedFrom } from 'aurelia-framework';
import {inject} from 'aurelia-framework';
import {HttpClient} from 'aurelia-http-client';

@inject(HttpClient)
export class News {
    heading = 'From Bricks to Bothans';
    url = 'http://fbtb.dwhisper.com/wp-json/posts';
    articles = [];

    constructor(http) {
        this.http = http;
    }

    submit() {
        
    }

    canDeactivate() {
        
    }

    activate(settings) {
        return this.http.get(this.url).then(response => {
          this.articles = response.content;
            console.log(this.articles);
        });
    }
}

export class UpperValueConverter {
    toView(value) {
        return value && value.toUpperCase();
    }
}