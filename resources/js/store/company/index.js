import {combineReducers} from "redux";
import list from './list'
import show from './show'
import sub_list from './sub-list'
import station from './station'

export default combineReducers({
    list,
    sub_list,
    show,
    station,
})
