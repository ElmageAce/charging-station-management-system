import React, {Component} from 'react';
import {connect} from 'react-redux';
import StationsList from './StationsList'
import SubCompaniesList from './SubCompaniesList'
import Container from "../../../ui/Container";
import {sendCompanyShowRequest} from "../../../store/company/show/actions";

class Show extends Component {
    constructor(props) {
        super(props)

        this.state = {
            id: props.match.params.id
        }
    }

    static getDerivedStateFromProps(props, state) {
        if(state.id !== props.match.params.id) {
            props.fetchCompany()

            return {id: props.match.params.id}
        } else {
            return null
        }
    }

    render() {
        return (
            <Container>
                <div className="card">
                    <div className="card-header">{this.props.company.name}</div>

                    <div className="card-body">
                        <form>
                            <div className="form-group row">
                                <label htmlFor="staticId" className="col-sm-2 col-form-label">Id</label>
                                <div className="col-sm-10">
                                    <span className="form-control-plaintext" id="staticId">
                                        {this.props.company.id}
                                    </span>
                                </div>
                            </div>
                            {this.props.company.parent_company && <div className="form-group row">
                                <label htmlFor="staticParentName" className="col-sm-2 col-form-label">Parent</label>
                                <div className="col-sm-10">
                                    <span className="form-control-plaintext" id="staticParentName" onClick={() => _history.push('/company/' + this.props.company.parent_company.id)}>
                                        {this.props.company.parent_company.name}
                                    </span>
                                </div>
                            </div>}
                        </form>

                        <div className="row">
                            <div className="col-md-6 col-sm-12">
                                <StationsList companyId={this.props.match.params.id}/>
                            </div>

                            <div className="col-md-6 col-sm-12">
                                <SubCompaniesList parentCompanyId={this.props.match.params.id}/>
                            </div>
                        </div>
                    </div>
                </div>
            </Container>
        );
    }

    componentDidMount() {
        this.props.fetchCompany()
    }
}

const mapStateToProps = state => ({
    company: state.company.show.company
})
const mapDispatchToProps = (dispatch, ownProps) => ({
    fetchCompany: () => dispatch(sendCompanyShowRequest(ownProps.match.params.id))
})
export default connect(mapStateToProps, mapDispatchToProps)(Show)
