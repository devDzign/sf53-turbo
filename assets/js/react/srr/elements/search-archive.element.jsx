import React, {useEffect, useState} from 'react';
import isTableElement from "@popperjs/core/lib/dom-utils/isTableElement";
import Loader from "../components/shop/loader.component";

const SearchArchive = (props) => {

    const [search, setSearch] = useState({
        dateSearch: `${new Date().getFullYear()}-${`${new Date().getMonth() +
        1}`.padStart(2, 0)}-${`${new Date().getDate() + 1}`.padStart(2, 0)}T${`${new Date().getHours()}`
                .padStart(2, 0)}:${`${new Date().getMinutes()}`.padStart(2, 0)}`+':'+
            new Date().getSeconds()
        ,
        companyId: props.companyId,
        dateCreated: props.dateCreated,
        data: [],
        isLoading: false
    })

    const handleChange = (event) => {
        const {value, name} = event.target;
        setSearch(prevState => ({...prevState, [name]: value}));
    }

    const handleSubmit = (event) => {
        event.preventDefault()
        fetchArchive();
    }

    const fetchArchive = async () => {
        setSearch(prevState => ({...prevState, isLoading: true}));
        const response = await fetch(`/api/search/${search.companyId}/archive/${search.dateSearch}/exact`);
        const res = await response.json();

        setSearch(prevState => ({
            ...prevState,
            data: res.data.archives,
            isLoading: false
        }));
    }


    return (
        <div>
            <div className="d-flex justify-content-center">
                <form className="row g-3" onSubmit={handleSubmit}>

                    <div className="input-group">
                        <input
                            type="datetime-local"
                            name={"dateSearch"}
                            id="datetime-local"
                            onChange={handleChange}
                            value={search.dateSearch}
                            step="1"
                        />
                        <div className="input-group-text" id="btnGroupAddon2">
                            <button type="submit" className="btn btn-primary">
                                <i className="fas fa-search"></i> Ok
                            </button>
                        </div>
                    </div>
                </form>
            </div>


            {search.isLoading ? (
                <div className="row d-flex justify-content-center align-content-center">
                    <Loader/>
                </div>
            ) : (<div className="row d-flex justify-content-start align-content-center">
                {search.data.map((item) => {
                    let company = item.data[0];

                    return (
                        <div className="col-md-4 mx-auto mb-3" key={item.id}>
                            <div className="card" style={{width: "20rem"}}>
                                <div className="d-flex justify-content-center">
                                    <h1><span className="badge bg-dark">Old Entity</span></h1>
                                </div>
                                <div className="d-flex justify-content-center">
                                    <h3>
                                        <span className="badge bg-info">{item.createdAt}</span>
                                    </h3>
                                </div>
                                <div className="card-header d-flex justify-content-start">
                                    <span className="">Renseignements juridiques</span>
                                </div>
                                <div className="card-body">
                                    <h5 className="card-title text-capitalize text-center">
                                        <i className="fa fa-building"></i> {company.name}
                                    </h5>
                                </div>
                                <ul className="list-group list-group-flush">

                                    <li className="list-group-item d-flex justify-content-between align-content-center">
                                        <span>Forme juridique:</span>
                                        <span></span>{company.legalCategory.wording}
                                    </li>

                                    <li className="list-group-item d-flex justify-content-between align-content-center">
                                        <span>La ville d'enregistrement:</span>
                                        <span>{company.cityOfRegistration}</span>
                                    </li>
                                    <li className="list-group-item d-flex justify-content-between align-content-center">
                                        <span>Numéro siren:</span>
                                        <span>{company.siren}</span>
                                    </li>
                                    <li className="list-group-item d-flex justify-content-between align-content-center">
                                        <span>Capital social: </span>
                                        <span>{company.capital}.00 €</span>
                                    </li>
                                </ul>
                                <div className="card-body">

                                    <h4 className="text-center">
                                        Total Adresses ({company.localizations.length})
                                    </h4>

                                    <div className="d-flex justify-content-center align-content-between">
                                        <div className="card me-1" style={{width: "20rem"}}>
                                            <div className="card-body">
                                                <div className="d-grid gap-1 mb-3">

                                                    <a href={`/company/${search.companyId}/archive/${item.id}`} className="btn btn-outline-success">
                                                        <i className="fas fa-map-marker-alt"></i> Show this
                                                        Version {item.createdAt}
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                    )
                })}
            </div>)}


        </div>
    );
};

export default SearchArchive;
