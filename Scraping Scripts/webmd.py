from _typeshed import NoneType
import threading
import requests
from bs4 import BeautifulSoup
from threading import Thread
import sys
import os
from time import sleep
from time import time
headers = {
    'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.183 Safari/537.36'
}

if not os.path.isfile('error.txt'):
    with open("error.txt", 'w', encoding='utf-8') as w:
        pass
else:
    print('no')


def file_generator(link, headers):
    res = requests.get(link, headers=headers)
    soup = BeautifulSoup(res.text, 'lxml')
    try:
        file_name = soup.select('h1')[0].text
    except:
        file_name = soup.title.split(":")[0].strip()
        with open("error.txt", "a", encoding='utf-8') as e:
            e.write("Name Error "+link+"\n")
        return

    txt = ""
    try:
        soup.select(".drug-review-lowest")[0].decompose()
    except:
        pass

    try:
        txt = " ".join(
            soup.find('div', {"class": "drug-names"}).text.strip().split())+"\n"
    except:
        pass

    try:
        txt = txt+soup.select("#tab-2")[0].h2.text+"\n"
        para = soup.select("#tab-2")[0].select('p')

    except:
        para = soup.find(attrs={"class": 'side-effects-container center-content'}
                         ).find(attrs={"class": 'monograph-content'}).find_all('p')

    try:

        for t in para:
            if "In the US -" in t.text:
                break
            else:
                txt = txt+t.text+" "

        #txt = ' '.join(x.strip() for x in txt.strip().split())
        forbidden = ['\\', '/', ':', '*', '\'',
                     '<', '>', '|', '.', '-', '\"', '&', '?']

        for i in file_name:
            if i in forbidden:
                file_name = file_name.replace(i, " ")

        with open(file_name.strip()+".txt", "w", encoding='utf-8') as f:
            f.write(txt)
    except:
        with open("error.txt", "a", encoding='utf-8') as e:
            e.write(link+"\n")
        print("Error Link", link)


c1 = time()
print(c1)
lst = set()
base_url = "https://www.webmd.com/drugs/2/alpha/"
main_url = "https://www.webmd.com/"
for i in range(97, 123):
    res = requests.get(base_url+chr(i)+"/", headers=headers)
    soup = BeautifulSoup(res.text, 'lxml')
    for link in soup.find("div", {"class": "drugs-browse-subbox"}).find('ul').find_all('a'):
        complete_url = (requests.compat.urljoin(main_url, link["href"]))
        res2 = requests.get(complete_url, headers=headers)
        soup2 = BeautifulSoup(res2.text, 'lxml')
        try:
            for drug in soup2.find(attrs={"class": "drug-list"}).find_all('a'):
                drug_url = (requests.compat.urljoin(main_url, drug["href"]))
                if drug_url not in lst:
                    lst.add(drug_url)
                    t = Thread(target=file_generator, args=(drug_url, headers))
                    t.start()
                    # if threading.active_count()>400:
                    #     sleep(5)
        except:
            pass
        # sleep(5)
lst = list(lst)
print(lst[0])
print(len(lst))
print(len(set(lst)))
print(time()-c1)
