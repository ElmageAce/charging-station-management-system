import React, {Component} from 'react';
import {connect} from 'react-redux';
import {sendCompaniesIndexRequest} from "../../../store/company/list/actions";
import ListCard from "./ListCard";
import Container from '../../../ui/Container'
import Paginator from "../../../ui/Paginator";
import {sendCompanyCreateRequest} from "../../../store/company/create/actions";

class List extends Component {
    render() {
        return (
            <Container>
                <Paginator paginated_list={this.props.paginated_list} onChangePage={p => this.props.fetchCompanies(p)}/>

                <ListCard paginated_list={this.props.paginated_list}
                          hasAddRow={true}
                          onAdd={(name) => this.props.addCompany(name)}/>

                <Paginator paginated_list={this.props.paginated_list} onChangePage={p => this.props.fetchCompanies(p)}/>
            </Container>
        );
    }

    componentDidMount() {
        this.props.fetchCompanies()
    }
}

const mapStateToProps = state => ({
    paginated_list: state.company.list.paginated_list
})
const mapDispatchToProps = dispatch => ({
    fetchCompanies: (page = 1) => dispatch(sendCompaniesIndexRequest(page)),
    addCompany: (name) => dispatch(sendCompanyCreateRequest({name}))
})
export default connect(mapStateToProps, mapDispatchToProps)(List)
