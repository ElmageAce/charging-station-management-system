import React, {Component} from 'react';
import {connect} from 'react-redux';
import {sendCompanyStationsIndexRequest} from "../../../store/company/station/list/actions";
import Container from "../../../ui/Container";
import ListCard from "../../Station/List/ListCard";
import Paginator from "../../../ui/Paginator";
import {sendStationCreateRequest} from "../../../store/station/create/actions";

class Companies extends Component {
    constructor(props) {
        super(props)

        this.state = {
            companyId: props.companyId
        }
    }

    static getDerivedStateFromProps(props, state) {
        if (state.companyId !== props.companyId) {
            props.fetchStations()

            return {companyId: props.companyId}
        } else {
            return null
        }
    }

    render() {
        const {paginated_list, fetchStations} = this.props

        const paginator = <Paginator paginated_list={paginated_list} onChangePage={page => fetchStations(page)}/>

        return (
            <Container>
                <ListCard paginated_list={paginated_list}
                          title={'Stations'}
                          hasAddRow={true}
                          onAdd={this.props.addStation}/>

                {paginator}
            </Container>
        )
    }

    componentDidMount() {
        this.props.fetchStations()
    }
}

const mapStateToProps = state => ({
    paginated_list: state.company.station.list.paginated_list
})
const mapDispatchToProps = (dispatch, ownProps) => ({
    fetchStations: (page = 1) => dispatch(sendCompanyStationsIndexRequest(ownProps.companyId, page)),
    addStation: (data) => dispatch(sendStationCreateRequest({...data, company_id: ownProps.companyId}))
})
export default connect(mapStateToProps, mapDispatchToProps)(Companies)
