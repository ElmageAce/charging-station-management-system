import React, {Component} from 'react';
import {connect} from 'react-redux';
import ListCard from "./ListCard";
import Container from '../../../ui/Container'
import {sendStationsIndexRequest} from "../../../store/station/list/actions";
import Paginator from "../../../ui/Paginator";

class List extends Component {
    render() {
        const {paginated_list, fetchStations} = this.props

        const paginator = <Paginator paginated_list={paginated_list} onChangePage={page => fetchStations(page)}/>

        return (
            <Container>
                {paginator}

                <ListCard paginated_list={paginated_list}/>

                {paginator}
            </Container>
        );
    }

    componentDidMount() {
        this.props.fetchStations()
    }
}

const mapStateToProps = state => ({
    paginated_list: state.station.list.paginated_list
})
const mapDispatchToProps = dispatch => ({
    fetchStations: (page = 1) => dispatch(sendStationsIndexRequest(page))
})
export default connect(mapStateToProps, mapDispatchToProps)(List)
