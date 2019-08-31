select count(*) from test_partitioning PARTITION (p0)
UNION
select count(*) from test_partitioning PARTITION (p1)
UNION
select count(*) from test_partitioning PARTITION (p2)
UNION
select count(*) from test_partitioning PARTITION (p3)
UNION
select count(*) from test_partitioning PARTITION (p4)
UNION
select count(*) from test_partitioning PARTITION (p5)
UNION
select count(*) from test_partitioning PARTITION (p6)
UNION
select count(*) from test_partitioning PARTITION (p7)
UNION
select count(*) from test_partitioning PARTITION (p8)
UNION
select count(*) from test_partitioning PARTITION (p9)
