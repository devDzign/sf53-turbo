import { Controller } from 'stimulus';
import ReactDOM from 'react-dom';
import React from 'react';
import SearchArchive from "../js/react/srr/elements/search-archive.element";


export default class extends Controller {
    static values = {
        company: Number
    }

    connect() {
        ReactDOM.render(
            <SearchArchive companyId={this.companyValue}/>,
            this.element
        )
    }
}
