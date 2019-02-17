import * as types from './actionTypes'
import {paginated_list} from "../../../../utils/defaults";
import * as updateTypes from "../../../station/update/actionTypes";
import * as createTypes from "../../../station/create/actionTypes";

export default (state = initialState, action) => {
    switch (action.type) {
        case types.COMPANY_STATIONS_INDEX_REQUEST:
            return {...state, is_fetching: true}
        case types.COMPANY_STATIONS_INDEX_SUCCESS:
            return {...initialState, paginated_list: action.data}
        case types.COMPANY_STATIONS_INDEX_FAILURE:
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
        case createTypes.STATION_CREATE_SUCCESS:
            if (state.paginated_list.current_page === state.paginated_list.last_page) {
                return {
                    ...state,
                    paginated_list: {
                        ...state.paginated_list,
                        data: [...state.paginated_list.data, action.data]
                    }
                }
            } else {
                return state
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
