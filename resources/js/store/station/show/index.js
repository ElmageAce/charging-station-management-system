import * as types from './actionTypes'
import {station} from "../../../utils/defaults";

export default (state = initialState, action) => {
    switch (action.type) {
        case types.STATION_SHOW_REQUEST:
            return {...state, is_fetching: true}
        case types.STATION_SHOW_SUCCESS:
            return {...initialState, station: action.data}
        case types.STATION_SHOW_FAILURE:
            return {...initialState, error: action.error}
        default:
            return state
    }
}

const initialState = {
    station,
    is_fetching: false,
    error: null
};
