import React, {useEffect, useState} from 'react';
import {Row, Col, Spin, message} from 'antd';
import axios from "axios";
import Results from "./components/Results";

export default function App() {
    const [url, setUrl] = useState('');
    const [loading, setLoading] = useState(false);
    const [items, setItems] = useState([]);

    async function getData() {
        setLoading(true);
        try {
            await axios.post(`${process.env.MIX_URL}/api/crawl`, {
                'url': url,
            }).then((res) => {
                setItems(res.data.items)
                localStorage.setItem('crawler-items', JSON.stringify(res.data.items));
            });
            setLoading(false);
        } catch (err) {
            if(err.response.status === 422) {
                errorMessage(err.response.data.errors.url)
            } else {
                errorMessage(err.response.data.msg);
            }
        }
        setLoading(false);
    }

    const errorMessage = (msg) => {
        message.info(msg);
    };

    useEffect(() => {
        try {
            const storage = JSON.parse(localStorage.getItem('crawler-items'));
            if(storage !== null) {
                setItems(storage)
            }
        } catch (e) {
            localStorage.clear();
        }
    }, [])

    return (
        <Spin spinning={loading} size="large">
            <Row justify="space-around" align="middle">
                <Col span={24}>
                    <h1 className="text-center">Crawler</h1>
                </Col>
                <Col span={16} offset={8}>
                    <input
                        className="search-input"
                        placeholder="Enter url here"
                        onChange={e => setUrl(e.target.value)}
                    />
                    <button
                        className="search-btn"
                        onClick={getData}
                    >
                        start crawling!
                    </button>
                </Col>
            </Row>
            <Row>
                <Col span={24}>
                    <Results items={items} />
                </Col>
            </Row>
        </Spin>
    )
}
