import React, { Component } from 'react';
import { ReactDOM } from 'react-dom';

export default class Sample extends Component {
    constructor(props) {
        super(props);
        this.state = {
            num:0,
            message:'ok',
        };

        this.doAction = this.doAction.bind(this);
    }

    doAction(event) {
        this.setState((state) => ({
            message : 'wait...',
        }));

        axios.get('/test')
        .then(response => {
            console.log(response.data);
            const message = response.data.message;
            console.log(message);

            this.setState((state) => ({
                // person:person,
                // message:message
            }));
        });
    }

    render() {
        return (
            <div>
                <button onClick={this.doAction}>クリック</button>
            </div>
        )
    }
}