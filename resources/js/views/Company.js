import React from 'react'
import {Route} from "react-router-dom";

import List from '../components/Company/List'

export default () => {
    return (
        <div>
            <Route exact path={'/company'} component={List}/>
        </div>
    )
}
