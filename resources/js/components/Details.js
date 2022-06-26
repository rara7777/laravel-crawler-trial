import React, {useEffect, useState} from 'react';
import axios from "axios";
import {Col, message, Row, Spin} from "antd";
import {useNavigate, useParams} from 'react-router-dom';

export default function Details() {
    const navigate = useNavigate();
    const [loading, setLoading] = useState(false);
    const [item, setItem] = useState({});
    const { id } = useParams();

    useEffect(() => {
        const fetchData = async () =>{
            setLoading(true);
            try {
                const res = await axios.get(`${process.env.MIX_URL}/api/details/${id}`);
                setItem(res.data.item);
            } catch (err) {
                errorMessage(err.response.data.msg);
            }
            setLoading(false);
        }

        fetchData();
    }, [])

    const errorMessage = (msg) => {
        message.info(msg);
    };

    return (
        <Spin spinning={loading} size="large">
            <Row>
                <button onClick={() => navigate(-1)}>Go back</button>

                <Col span={24}>
                    <h2>Screenshot</h2>
                </Col>
                <Col span={24}>
                    <a href={item.screenshot} target="_blank">
                        <img src={item.screenshot} width="300px" />
                    </a>
                </Col>
                <Col span={24}>
                    <h2>Title</h2>
                </Col>
                <Col span={24}>
                    <a href={item.url} target="_blank">{item.title}</a>
                </Col>
                <Col span={24}>
                    <h2>Description</h2>
                </Col>
                <Col span={24}>
                    <p>{item.description}</p>
                </Col>
                <Col span={24}>
                    <h2>Created At</h2>
                </Col>
                <Col span={24}>
                    <p>{item.createdAt}</p>
                </Col>
                <Col span={24}>
                    <h2>Body</h2>
                </Col>
                <Col span={24}>
                    <p>{item.parsedBody}</p>
                </Col>
            </Row>
        </Spin>
    )
}
