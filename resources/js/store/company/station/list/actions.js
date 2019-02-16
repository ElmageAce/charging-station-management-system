import * as types from './actionTypes'
import httpRequest from "../../../../utils/http";

const createCompanyStationsIndexRequestAction = () => ({type: types.COMPANY_STATIONS_INDEX_REQUEST})
const createCompanyStationsIndexSuccessAction = (data) => ({type: types.COMPANY_STATIONS_INDEX_SUCCESS, data})
const createCompanyStationsIndexFailureAction = (error) => ({type: types.COMPANY_STATIONS_INDEX_FAILURE, error})

export const sendCompanyStationsIndexRequest = (companyId, page = 1) => dispatch => {
    dispatch(createCompanyStationsIndexRequestAction())
    const callbacks = {
        success: createCompanyStationsIndexSuccessAction,
        failure: createCompanyStationsIndexFailureAction
    }

    dispatch(httpRequest({url: '/api/company/' + companyId + '/station', method: 'get', params: {page}}, callbacks))
};
