import React, {Component} from 'react';
import {connect} from 'react-redux';
import {sendSubCompaniesIndexRequest} from "../../../store/company/sub-list/actions";
import ListCard from "../List/ListCard";
import Paginator from "../../../ui/Paginator";
import {sendCompanyCreateRequest} from "../../../store/company/create/actions";

class SubCompaniesList extends Component {
    constructor(props) {
        super(props)

        this.state = {
            parentCompanyId: props.parentCompanyId
        }
    }

    static getDerivedStateFromProps(props, state) {
        if (state.parentCompanyId !== props.parentCompanyId) {
            props.fetchSubCompanies()

            return {parentCompanyId: props.parentCompanyId}
        } else {
            return null
        }
    }

    render() {
        const paginator = <Paginator paginated_list={this.props.paginated_list}
                                     onChangePage={page => this.props.fetchSubCompanies(page)}/>

        return (
            <div>

                <ListCard paginated_list={this.props.paginated_list} title={'Sub-companies'}
                          hasAddRow={true}
                          onAdd={(name) => this.props.addCompany(name)}/>

                {paginator}
            </div>
        );
    }

    componentDidMount() {
        this.props.fetchSubCompanies()
    }
}

const mapStateToProps = state => ({
    paginated_list: state.company.sub_list.paginated_list
})

const mapDispatchToProps = (dispatch, ownProps) => ({
    fetchSubCompanies: (page = 1) => dispatch(sendSubCompaniesIndexRequest(ownProps.parentCompanyId, page)),
    addCompany: (name) => dispatch(sendCompanyCreateRequest({name, parent_company_id: ownProps.parentCompanyId}))
})

export default connect(mapStateToProps, mapDispatchToProps)(SubCompaniesList)
