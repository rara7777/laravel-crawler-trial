import React, {useState} from 'react';
import {Table, Row, Col, Input, Button, Space} from 'antd';
import {Link} from "react-router-dom";

export default function Results(props) {
    const [titleFilter, setTitleFilter] = useState('')
    const [descriptionFilter, setDescriptionFilter] = useState('')
    const [createdAtFilter, setCreatedAtFilter] = useState('')

    const columns = [
        {
            title: 'Screenshot',
            dataIndex: 'screenshot',
            key: 'screenshot',
            align: 'center',
            render: (screenshot) => {
                return (
                    <a href={screenshot} target="_blank">
                        <img src={screenshot} width="400px" />
                    </a>
                )
            }
        },
        {
            title: 'Title',
            key: 'title',
            align: 'center',
            width: 300,
            textWrap: 'word-break',
            ellipsis: true,
            render: (item) => {
                if(item.title) {
                    return (
                        <a href={item.url} target="_blank" key={item.url}>{item.title}</a>
                    );
                } else {
                    return (
                        <a href={item.url} target="_blank" key={item.url}>No Title Found</a>
                    )
                }
            },
        },
        {
            title: 'Description',
            dataIndex: 'description',
            key: 'description',
            align: 'center',
        },
        {
            title: 'Created At',
            dataIndex: 'createdAt',
            key: 'created_at',
            align: 'center',
            width: 150,
        },
        {
            title: 'Details',
            key: 'id',
            align: 'center',
            width: 100,
            render: (item) => {
                return (
                    <Space size="middle">
                        <Link to={"/details/" + item.id }>
                            <Button className="success"
                                size="middle"
                            >
                                details
                            </Button>
                        </Link>
                    </Space>
                )
            }
        },
    ];

    const filteredItems = props.items.filter(item =>
        item.title.toLowerCase().includes(titleFilter.toLowerCase())
    ).filter(item =>
        item.description.toLowerCase().includes(descriptionFilter.toLowerCase())
    ).filter(item =>
        item.createdAt.includes(createdAtFilter)
    );

    return (
        <div className="filter-section">
            <Row gutter={[16,16]}>
                <Col span={8}>
                    Title Filter:
                    <Input allowClear={true} onChange={e => setTitleFilter(e.target.value)} />
                </Col>
                <Col span={8}>
                    Description Filter:
                    <Input allowClear={true} onChange={e => setDescriptionFilter(e.target.value)} />
                </Col>
                <Col span={8}>
                    CreatedAt Filter:
                    <Input allowClear={true} onChange={e => setCreatedAtFilter(e.target.value)} />
                </Col>
                <Col span={24}>
                    <Table
                        dataSource={filteredItems}
                        columns={columns}
                        rowKey={item => item.id}
                        pagination={{ defaultPageSize: 10, showSizeChanger: true, pageSizeOptions: ['10', '20', '30']}}
                    />
                </Col>
            </Row>
        </div>
    )
}
