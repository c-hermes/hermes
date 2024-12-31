import {ref } from 'vue'

const index1 = ref(1)
const index2 = ref(1)

  // Inversion des positions de 2 item dans un tableau
export function useChangeIndex (myitems, direction, index, URI){
  const indexes = useSwitchIndex(direction, index,myitems.length)
  index1.value = indexes.index1
  index2.value = indexes.index2

  myitems.value = myitems.splice(index1.value, 1, myitems.splice(index2.value, 1, myitems[index1.value])[0]);

  const up = myitems[index1.value]
  const down = myitems[index2.value]

  // mise à jour des position en base de donnée
  useAjaxSwitchPosition(URI, down['id'], up['id'])

  return myitems
}

// on met à jour les positions des 2 items en base
export function useAjaxSwitchPosition(uri, id1, id2){
    const requestOptions = {
    method: "POST",
    headers: { 
        'Content-Type': 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
        'Authorization': 'Bearer my-token',
    },
    body: JSON.stringify({'id1': id1,  'id2': id2 })
  };
  fetch(uri, requestOptions)
    .then(response => response.json())
}

export function useMyfilter(selected, item) {
  if(item!= selected && 'all' != selected){
      return false
  }
  return true
}

export function useSwitchIndex(direction, index, myitemslength) {
    if('up' == direction){
        if(index == myitemslength){
            index1.value = index - 1
            index2.value = index - 2
        }else{
            index1.value = index
            index2.value = index - 1
        }
    }
    if('down' == direction){
        index1.value = index + 1
        index2.value = index
    }

    return { 'index1': index1.value, 'index2': index2.value }
  }
