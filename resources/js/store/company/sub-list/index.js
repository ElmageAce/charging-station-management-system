import * as types from './actionTypes'
import {paginated_list} from "../../../utils/defaults";
import * as updateTypes from "../update/actionTypes";
import * as createTypes from "../create/actionTypes";

export default (state = initialState, action) => {
    switch (action.type) {
        case types.SUB_COMPANIES_INDEX_REQUEST:
            return {...state, is_fetching: true}
        case types.SUB_COMPANIES_INDEX_SUCCESS:
            return {...initialState, paginated_list: action.data}
        case types.SUB_COMPANIES_INDEX_FAILURE:
            return {...initialState, error: action.error}
        case updateTypes.COMPANY_UPDATE_SUCCESS:
            return {
                ...state,
                paginated_list: {
                    ...state.paginated_list,
                    data: state.paginated_list.data.map(
                        company => company.id === action.data.id ? action.data : company
                    )
                }
            }
        case createTypes.COMPANY_CREATE_SUCCESS:
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
