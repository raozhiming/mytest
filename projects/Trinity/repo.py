#!/usr/bin/env python3

import config
import os
import sys
import subprocess
import argparse
import distutils.dir_util as dir_util

parser = argparse.ArgumentParser(description='Clone the Elastos.Trinity project.',
                                 formatter_class=argparse.RawTextHelpFormatter)
parser.add_argument('target', metavar='TARGET', choices=['clone', 'merge'],
                    help='Specify the target to build.\nPossible values are "clone" and "merge".')

args = parser.parse_args()

SCRIPT_PATH = os.path.realpath(__file__)
SCRIPT_DIR_PATH = os.path.dirname(SCRIPT_PATH)
CWD = os.getcwd()


def run_cmd(cmd, ignore_error=False):
    print("Running: " + cmd)
    ret = subprocess.call(cmd, shell=True)
    if not ignore_error and ret != 0:
        print("run_cmd error ret:" + str(ret) + " cmd:" + cmd)
        sys.exit(ret)


def update_repo(dirname, branch, forkform=None):
    print("update_repo")
    os.chdir(dirname)

    if forkform:
        cmd = "git checkout " + branch
        run_cmd(cmd)
        cmd = "git fetch --all -p"
        run_cmd(cmd)
        cmd = "git rebase upstream/" + branch
        run_cmd(cmd)
        cmd = "git push origin " + branch
        run_cmd(cmd)
    else:
        cmd = "git pull"
        run_cmd(cmd)

    os.chdir(SCRIPT_DIR_PATH)


def clone_repo(dirname, reponame, branch, forkform=None):
    print("clone_repo:" + dirname)
    if os.path.exists(dirname):
        return update_repo(dirname, branch, forkform)

    cmd = "git clone " + reponame
    run_cmd(cmd)

    os.chdir(dirname)

    if forkform:
        cmd = "git remote add upstream " + forkform
        run_cmd(cmd)

    # Elastos.Trinity.ToolChains no branch
    if branch != "master":
        cmd = "git checkout -b " + branch + " origin/"+branch
        run_cmd(cmd)

    os.chdir(SCRIPT_DIR_PATH)


def clone_repos():
    repoconfig = config.Config()
    for repo_name in repoconfig.repo:
        forkform=None
        if 'forkfrom' in repoconfig.repo[repo_name]:
            forkform = repoconfig.repo[repo_name]['forkfrom']
        clone_repo(repo_name, repoconfig.repo[repo_name]["url"], repoconfig.repo[repo_name]["workbranch"], forkform)


def merge_repo(dirname, branch, mergeto):
    print("merge_repo")
    os.chdir(dirname)

    cmd = "git checkout " + mergeto
    run_cmd(cmd)

    cmd = "git merge " + branch
    run_cmd(cmd)

    # cmd = "git push origin " + mergeto
    # run_cmd(cmd)

    os.chdir(SCRIPT_DIR_PATH)


def merge_repos():
    print("merge_repos")
    repoconfig = config.Config()
    for repo_name in repoconfig.repo:
        merge_repo(repo_name, repoconfig.repo[repo_name]["workbranch"], repoconfig.repo[repo_name]["mergeto"])


def remove_tree(directory):
    print("Removing: " + directory)
    if os.path.isdir(directory):
        dir_util.remove_tree(directory)


if args.target == "clone":
    clone_repos()

if args.target == "merge":
    merge_repos()

print("Done")
