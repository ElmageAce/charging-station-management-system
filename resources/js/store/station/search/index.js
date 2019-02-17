import * as types from './actionTypes'
import {paginated_list} from "../../../utils/defaults";
import * as updateTypes from "../update/actionTypes";

export default (state = initialState, action) => {
    switch (action.type) {
        case types.STATIONS_SEARCH_REQUEST:
            return {...state, is_fetching: true}
        case types.STATIONS_SEARCH_SUCCESS:
            return {...initialState, paginated_list: action.data}
        case types.STATIONS_SEARCH_FAILURE:
            return {...initialState, error: action.error}
        case updateTypes.STATION_UPDATE_SUCCESS:
            return {
                ...state,
                paginated_list: {
                    ...state.paginated_list,
                    data: state.paginated_list.data.map(
                        station => station.id === action.data.id ? action.data : station
                    )
                }
            }
        default:
            return state
    }
}

const initialState = {
    paginated_list,
    is_fetching: false,
    error: null
};
