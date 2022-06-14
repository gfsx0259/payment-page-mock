FROM centos/systemd

RUN yum -y install cron; yum clean all;

COPY callbacks.sh /root/callbacks.sh
RUN chmod +x /root/callbacks.sh

CMD ["/root/callbacks.sh"]
