import React from 'react';
import Container from "../ui/Container";
import CompaniesList from "../components/Company/List";
import StationsList from "../components/Station/List";
import StationSearchList from "../components/Station/Search";

const MainView = (props) => {
    const navigateTo = (e, destination) => {
        e.preventDefault()

        _history.push(destination)
    }

    const {path} = props.match

    return (
        <Container>
            <div className="card">
                <div className="col">
                    <div className="col">
                    <ul className="nav nav-tabs">
                        <li className="nav-item">
                            <a className={"nav-link" + (path === '/company' ? ' active' : '')}
                               href="#"
                               onClick={e => navigateTo(e, '/company')}>
                                Companies
                            </a>
                        </li>
                        <li className="nav-item">
                            <a className={"nav-link" + (path === '/station' ? ' active' : '')}
                               href="#"
                               onClick={e => navigateTo(e, '/station')}>
                                Stations
                            </a>
                        </li>
                        <li className="nav-item">
                            <a className={"nav-link" + (path === '/station-search' ? ' active' : '')}
                               href="#"
                               onClick={e => navigateTo(e, '/station-search')}>
                                Search for Stations
                            </a>
                        </li>
                    </ul>
                    </div>
                    <div className="tab-content">
                        {path === '/company' && <CompaniesList/>}
                        {path === '/station' && <StationsList/>}
                        {path === '/station-search' && <StationSearchList/>}
                    </div>
                </div>
            </div>
        </Container>
    )
}

export default MainView
