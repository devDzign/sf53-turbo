import React, { useCallback, useState } from 'react';
import { jsonLdFetch } from "../api/user.api";


const usePaginatedFetch = (url) => {

    const [loading, setLoading] = useState(false);
    const [users, setUsers] = useState([]);
    const [count, setCount] = useState(0);
    const [nextPage, setNextPage] = useState(null);

    const onLoadHandler = useCallback( async () => {
        setLoading(true);


        try {
            const urlCall = nextPage ? nextPage : url;
            const data =  await jsonLdFetch(urlCall);

            setUsers(items => [...items, ...data['hydra:member']]);
            setCount(data['hydra:totalItems']);

            if (data['hydra:view'] && data['hydra:view']['hydra:next']) {
                setNextPage(data['hydra:view']['hydra:next'])
            } else {
                setNextPage(null)
            }

        } catch (e) {
            console.log(e)
        }

        setLoading(false)

    }, [url, nextPage])


    return {
        loading,
        onLoadHandler,
        users,
        count,
        hasMore: nextPage !== null,
        nextPage
    }

}

export default usePaginatedFetch;

