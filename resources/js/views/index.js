import React from 'react'
import {Redirect, Route} from "react-router-dom";
import MainView from './MainView'
import ShowCompany from "../components/Company/Show";
import ShowStation from "../components/Station/Show";

export default (props) => {
    return (
        <div>
            {/*<Route exact path="/" component={MainView}/>*/}
            <Redirect from='/' to='/company'/>
            <Route exact path="/company" component={MainView}/>
            <Route exact path={'/company/:id'} component={ShowCompany}/>

            <Route exact path="/station" component={MainView}/>
            <Route exact path="/station-search" component={MainView}/>
            <Route exact path={'/station/:id'} component={ShowStation}/>
        </div>
    )
}
