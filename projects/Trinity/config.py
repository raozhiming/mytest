#!/usr/bin/env
# -*- coding: utf-8 -*-

import io
import os
import subprocess
import yaml


class Config:
    """
    parse config/trinity_repo.yaml
    """

    def __init__(self, config='trinity_repo.yaml'):
        self.config = self.get_config_data(config)

    @staticmethod
    def get_config_data(config):
        try:
            config_path = os.path.join("config", config)
            with io.open(config_path, encoding='utf-8') as fin:
                config = yaml.load(fin)
        except Exception as exc:
            raise exc
        return config

    @property
    def repo(self):
        return self.config['repo']

    @property
    def repo_count(self):
        return len(self.config['repo'])

if __name__ == "__main__":
    '''
    '''
    config = Config()
    print(config.repo)
    print(config.repo_count)
    for repo_name in config.repo:
        print(config.repo[repo_name])
        cmd = "git clone " + config.repo[repo_name]["url"]

        for keyname in config.repo[repo_name]:
            print(keyname)
        if not 'name' in config.repo:
            print("ok")
        # ret = subprocess.call(cmd, shell=True)
        # print(ret)



