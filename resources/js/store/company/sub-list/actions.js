import * as types from './actionTypes'
import httpRequest from "../../../utils/http";

const createIndexRequestAction = () => ({type: types.SUB_COMPANIES_INDEX_REQUEST})
const createIndexSuccessAction = (data) => ({type: types.SUB_COMPANIES_INDEX_SUCCESS, data})
const createIndexFailureAction = (error) => ({type: types.SUB_COMPANIES_INDEX_FAILURE, error})

export const sendSubCompaniesIndexRequest = (parentCompanyId, page = 1) => dispatch => {
    dispatch(createIndexRequestAction())
    const callbacks = {
        success: createIndexSuccessAction,
        failure: createIndexFailureAction
    }

    dispatch(httpRequest({
        url: '/api/company/' + parentCompanyId + '/sub-companies',
        method: 'get',
        params: {page}
    }, callbacks))
};
