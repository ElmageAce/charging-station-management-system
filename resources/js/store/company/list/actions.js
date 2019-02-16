import * as types from './actionTypes'
import httpRequest from "../../../utils/http";

const createIndexRequestAction = () => ({type: types.COMPANIES_INDEX_REQUEST})
const createIndexSuccessAction = (data) => ({type: types.COMPANIES_INDEX_SUCCESS, data})
const createIndexFailureAction = (error) => ({type: types.COMPANIES_INDEX_FAILURE, error})

export const sendCompaniesIndexRequest = (page = 1) => dispatch => {
    dispatch(createIndexRequestAction())
    const callbacks = {
        success: createIndexSuccessAction,
        failure: createIndexFailureAction
    }

    dispatch(httpRequest({url: '/api/company', method: 'get', params: {page}}, callbacks))
};
