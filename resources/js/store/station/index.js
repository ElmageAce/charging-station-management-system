import {combineReducers} from "redux";
import list from './list'
import show from './show'
import search from './search'

export default combineReducers({
    list,
    show,
    search,
})
