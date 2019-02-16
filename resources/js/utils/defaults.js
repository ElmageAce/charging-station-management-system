export const paginated_list = {
    current_page: 0,
    data: [],
    first_page_url: null,
    from: 0,
    last_page: 0,
    last_page_url: null,
    next_page_url: null,
    path: '',
    per_page: 0,
    prev_page_url: null,
    to: 0,
    total: 0
}

export const company = {
    id: null,
    name: null,
    parent_company: null
}


export const location = {
    type: 'Point',
    coordinates: [51.355399, 35.764312]
}

export const station = {
    id: null,
    name: null,
    company: company,
    location: location
}

