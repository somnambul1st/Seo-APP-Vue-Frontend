create table if not exists ya_search_pos
(
    project_id          UInt32,
    keyword_id          UInt32,
    pos                 UInt8,
    created_at          DateTime
)
    engine = MergeTree PARTITION BY toYYYYMM(created_at)
    sample by project_id
    order by (project_id, keyword_id, toYYYYMMDD(created_at))
    settings index_granularity = 8192;



create table if not exists google_search_pos
(
    project_id          UInt32,
    keyword_id          UInt32,
    pos                 UInt8,
    created_at          DateTime
)
    engine = MergeTree PARTITION BY toYYYYMM(created_at)
    sample by project_id
    order by (project_id, keyword_id, toYYYYMMDD(created_at))
    settings index_granularity = 8192;



create table if not exists ya_ws
(
    project_id            UInt32,
    keyword_id            UInt32,
    base_frequency        UInt32,
    quote_frequency       UInt32,
    quote_point_frequency UInt32,
    created_at            DateTime
)
    engine = MergeTree PARTITION BY toYYYYMM(created_at)
    sample by project_id
    order by (project_id, keyword_id, base_frequency, quote_frequency, quote_point_frequency, toYYYYMMDD(created_at))
    settings index_granularity = 8192;


create table if not exists keywords
(
    id              UInt32,
    project_id      UInt32,
    group_id        UInt32,
    name            UInt32,
    created_at      DateTime
)
    engine = MergeTree PARTITION BY toYYYYMM(created_at)
    sample by project_id
    order by (project_id, group_id, toYYYYMMDD(created_at))
    settings index_granularity = 8192;

create table if not exists groups
(
    id              UInt32,
    project_id      UInt32,
    group_id        UInt32,
    name            UInt32,
    created_at      DateTime
)
    engine = MergeTree PARTITION BY toYYYYMM(created_at)
    sample by project_id
    order by (project_id, group_id, toYYYYMMDD(created_at))
    settings index_granularity = 8192;


CREATE TABLE categories AS postgresql('home-pg-main-1:5432', 'seo-app', 'categories', 'seo-app', '8b3ohY$YF2PI#J@8niSz0n5B');

select countIf(ya_search_pos.pos <= 3) as top3, countIf(ya_search_pos.pos <= 5) as top5 from ya_search_pos left join keywords k on ya_search_pos.keyword_id = k.id where project_id = 11
---group by ya_search_pos.keyword_id
limit 1000;


select
    toDate(ya_search_pos.created_at) as date,
    countIf(ya_search_pos.pos <= 3) as top3,
    countIf(ya_search_pos.pos <= 10) as top10,
    countIf(ya_search_pos.pos > 10 and ya_search_pos.pos <= 30) as top30,
    countIf(ya_search_pos.pos > 30 and ya_search_pos.pos <= 50) as top50,
    countIf(ya_search_pos.pos > 50 and ya_search_pos.pos <= 100) as top100,
    countIf(ya_search_pos.pos > 100) as top101,
    round(avg(ya_search_pos.pos), 0) as avg,
    count() as keywords_count
from ya_search_pos
    --left join keywords k on ya_search_pos.keyword_id = k.id
where project_id = 5
group by date
order by date
    limit 1000;

select
    keywords.id,
    keywords.text,
    toDate(ysp.created_at) as date,
    max(ysp.pos)
from keywords
    right join ya_search_pos ysp on keywords.id = ysp.keyword_id
where ysp.created_at = '2023-01-01'
group by keywords.id, keywords.text, date
    limit 100;

['2023-03-01', '2023-03-02', '2023-03-03', '2023-03-04', '2023-03-05', '2023-03-06', '2023-03-07', '2023-03-08', '2023-03-09', '2023-03-10', '2023-03-11', '2023-03-12', '2023-03-13', '2023-03-14', '2023-03-15', '2023-03-16', '2023-02-01', '2023-02-02', '2023-02-03', '2023-02-04', '2023-02-05', '2023-02-06', '2023-02-07', '2023-02-08', '2023-02-09', '2023-02-10', '2023-02-11', '2023-02-12', '2023-02-13', '2023-02-14', '2023-02-15', '2023-02-16', '2023-03-17', '2023-03-18', '2023-03-19', '2023-03-20', '2023-03-21', '2023-03-22', '2023-03-23', '2023-03-24', '2023-03-25', '2023-03-26', '2023-01-22', '2023-01-23', '2023-01-24', '2023-01-25', '2023-01-26', '2023-01-27', '2023-01-28', '2023-01-29', '2023-02-27', '2023-02-28', '2023-01-01', '2023-01-02', '2023-01-03', '2023-01-04', '2023-01-05', '2023-01-06', '2023-01-07', '2023-01-08', '2023-01-09', '2023-01-10', '2023-01-11', '2023-01-12', '2023-01-13', '2023-01-14', '2023-01-15', '2023-01-16', '2023-01-17', '2023-01-18', '2023-01-19', '2023-01-20', '2023-01-21', '2023-02-17', '2023-02-18', '2023-02-19', '2023-02-20', '2023-02-21', '2023-02-22', '2023-02-23', '2023-02-24', '2023-02-25', '2023-02-26', '2023-03-27', '2023-03-28', '2023-01-30', '2023-01-31']

select
    ya_search_pos.keyword_id,
    groupArray(toDate(ya_search_pos.created_at)) as date,
    groupArray(toInt32(ya_search_pos.pos)) as pos
from ya_search_pos
    --left join keywords k on ya_search_pos.keyword_id = k.id
where project_id = 5 and ya_search_pos.keyword_id = 164672  --and ya_search_pos.created_at = '2023-03-17'
group by ya_search_pos.keyword_id
--order by ya_search_pos.created_at
    limit 100;

mapFromArrays



create table if not exists google_search_pos
(
    project_id          UInt32,
    keyword_id          UInt32,
    pos                 UInt8,
    created_at          DateTime
)
    engine = ReplacingMergeTree PARTITION BY toYYYYMM(created_at)
    PRIMARY KEY (project_id, keyword_id, toYYYYMMDD(created_at))
    sample by project_id
    order by (project_id, keyword_id, toYYYYMMDD(created_at))
    settings index_granularity = 8192;

OPTIMIZE table google_search_pos FINAL;

select
    google_search_pos.keyword_id,
    CAST((groupArray(toYYYYMMDD(google_search_pos.created_at)), groupArray(toInt32(google_search_pos.pos))), 'Map(Int32, Int32)') as pos
    --mapFromArrays(groupArray(toYYYYMMDD(google_search_pos.created_at)) as date, groupArray(toInt32(google_search_pos.pos)) as pos)
from google_search_pos
    --left join keywords k on ya_search_pos.keyword_id = k.id
where project_id = 5 --and ya_search_pos.created_at = '2023-03-17'
group by google_search_pos.keyword_id
--order by google_search_pos.keyword_id
limit 200
;