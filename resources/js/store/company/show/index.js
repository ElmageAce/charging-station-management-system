import * as types from './actionTypes'
import {company} from "../../../utils/defaults";

export default (state = initialState, action) => {
    switch (action.type) {
        case types.COMPANY_SHOW_REQUEST:
            return {...state, is_fetching: true}
        case types.COMPANY_SHOW_SUCCESS:
            console.log(action.data)
            return {...initialState, company: action.data}
        case types.COMPANY_SHOW_FAILURE:
            return {...initialState, error: action.error}
        default:
            return state
    }
}

const initialState = {
    company,
    is_fetching: false,
    error: null
};
