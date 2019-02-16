import React from 'react'
import ReactDOM from "react-dom";
import App from "./views";
import {applyMiddleware, createStore} from 'redux';
import thunk from 'redux-thunk';
import {Provider} from 'react-redux'
import rootReducer from './store';
import {Router} from "react-router-dom";

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes React and other helpers. It's a great starting point while
 * building robust, powerful web applications using React + Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh React component instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const store = createStore(
    rootReducer,
    applyMiddleware(thunk)
);

if (document.getElementById('react-app')) {
    ReactDOM.render(
        <Provider store={store}>
            <Router history={_history}>
                <App />
            </Router>
        </Provider>,
        document.getElementById('react-app')
    );
}
